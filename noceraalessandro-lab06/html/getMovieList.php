<?php

//inizializzazione db
$dbconnstr = "mysql:dbname=imdb_small;host=localhost:3306";
$dbuser = "root";
$dbpassword = "";
$db = new PDO($dbconnstr, $dbuser, $dbpassword);
$GLOBALS['db'] = $db;
//inizializzazione xml
header("Content-type: application/xml");

//funzione di formattazione query
function filter_chars($str) {
	return preg_replace("/[^A-Za-z0-9_]*/", "", $str);
}

//verifico che il server sia settato correttamente
if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}
//verifico che tutti i parametrisiano settati
if(!isset($_GET['name']) || !isset($_GET['surname']) || !isset($_GET['all'])){
    //errore bloccato prima di inviare la richiesta ajax
    print "ERRORE! qualcosa è andato storto";
    exit;
}

//prendo i parametri passati con GET e li preparo già per la query
$surname = $db->quote(filter_chars($_GET["surname"]));
$name = $db->quote(filter_chars($_GET["name"])."%");//.% -> uno o più caratteri
$all = filter_chars($_GET["all"]);

//tramite la funzione ottengo l'id dell'attore
$idattore = findId($name, $surname);

//verifica che l'attore esista
if($idattore==-1){
    echo "Nessun attore con questo nome";
    exit;
}else{
    $res = null;
    if($all==true){
        $res = $db->query("SELECT m.name, m.id, m.year
		FROM roles r
		JOIN movies m ON m.id = r.movie_id
		WHERE r.actor_id = $idattore
		ORDER BY m.year;");
    }else if($all=="false"){
        $res = $db->query("SELECT m.name, m.id, m.year
		FROM roles r
		JOIN movies m ON m.id = r.movie_id
		JOIN roles rk ON rk.movie_id=r.movie_id
		JOIN actors k ON k.id=rk.actor_id
		WHERE r.actor_id = $idattore
		AND k.first_name='Kevin' AND k.last_name='Bacon'
		ORDER BY m.year;");
    }else{
        echo "Valore parametro inatteso";
        exit;
    }
    if($res){
        //inizializzazione xml
        print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        //formattazione dell'xml una radice root e tanti figli film
        print "<root>\n";
        foreach($res as $row){
            print "<film>\n";
            print "<id>".toXml($row['id'])."</id>\n";
            print "<nome>".toXml($row['name'])."</nome>\n";
            print "<anno>".toXml($row['year'])."</anno>\n";
            print "</film>\n";
        }
        print "</root>";
    }else{
        echo "Nessun film con questo attore";
        exit;
    }
 
}


function findId($name, $surname){
    $db = $GLOBALS['db'];
    $rows = $db ->query("SELECT * FROM actors WHERE last_name = $surname AND first_name like $name");//query per trovare gli attori
    $id = -1;
    $f_count=0;
    if($rows->rowCount() > 0){//controllo che la query abbia prodotto risultati
        foreach($rows as $row){
            if($row['film_count']> $f_count){//per ogni risultato cerco l'attore con numero di film maggiore
                $id = $row['id'];
            }
        }
    }
    return $id;
}

//funzione per far accettare caratteri speciali a xml, modifica la stringa in input
function toXml($string){
    $cerca = array("&");//aggiungere caratteri non riconosciuti se necessario
    $sostituisci = array("&#38;");//aggiungere come sostituire i caratteri non riconosciuti s enecessario
    return str_replace($cerca, $sostituisci, $string);
}
?>