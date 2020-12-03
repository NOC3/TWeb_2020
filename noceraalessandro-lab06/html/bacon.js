//funzione chiamata alla creazione della pagina, assegna la funzione al click sul bottone
$(function(){
    $("#searchall").find('[name="submit"]').click(searchAll);
    $("#searchkevin").find('[name="submit"]').click(searchBacon);

});

//funzione per cercare tutti i film di un attore (nella richiesta ajax setto all=true, serve poi in getMovieList.php)
function searchAll(){
    //prendo i valori dai campi input
    $name = $("#searchall").find('[name="firstname"]').val();
    $surname = $("#searchall").find('[name="lastname"]').val();
    if($name != "" && $surname != ""){ //check not empty
        //richiesta ajax
        $.ajax({
            url: "getMovieList.php", //file che gestisce la richiesta
            type: "GET", //tipo di comunicazione
            data: "all=true&name="+$name+"&surname="+$surname, //dati passati a getMovieList.php tramite il tipo di comunicazione
            datatype: "xml", //tipo dei valori di ritorno
            success: showFilm, //funzione chiamata automaticamente se ajax funziona
            error: ajaxFailed //funzione chiamata automaticamente se ajax non funziona
        });
    }else{
        alert("Riempi campi input");//messaggio di comunicazione
    }
    
    
}

//logica uguale a searchAll, cambiano i riferimenti agli input e il parametro all(=false)
function searchBacon(){
    $name = $("#searchkevin").find('[name="firstname"]').val();
    $surname = $("#searchkevin").find('[name="lastname"]').val();
    if($name != "" && $surname != ""){
        $.ajax({
            url: "getMovieList.php",
            type: "GET",
            data: "all=false&name="+$name+"&surname="+$surname,
            datatype: "xml",
            success: showFilm,
            error: ajaxFailed
        });
    }else{
        alert("Riempi campi input");
    }
}

//funzione chiamata se ajax ha successo
function showFilm(xml){
    $("#list tbody").empty();
    var initstr = "<tr>\
                <th>#</th>\
                <th>Name</th>\
                <th>Year</th>\
                </tr>";
    $("#list tbody").append(initstr);    
    console.log("SUCCESS!");//messaggio di servizio
    var films = xml.getElementsByTagName("film");//prendo i tag film (vedi formattazione xml di getMovieList.php)
    for (var i = 0; i < films.length; i++) {
        var filmId  = films[i].getElementsByTagName("id")[0].firstChild.nodeValue;//per ogni tag "film", prendo i "sottotag" "id", "nome", "anno", ne estraggo il valore
        var filmName = films[i].getElementsByTagName("nome")[0].firstChild.nodeValue;
        var filmYear = films[i].getElementsByTagName("anno")[0].firstChild.nodeValue;
        $str = "<tr>\
            <td>"+filmId+"</td>\
            <td>"+filmName+"</td>\
            <td>"+filmYear+"</td>\
            </tr>"; //formatto la riga della tabella da aggiungere

        $("#list tbody").append($str);//aggiungo la riga alla tabella
    }    
}

//funzione chiamata se ajax fallisce
function ajaxFailed(e) {
	var errorMessage = "Errore richiesta Ajax:\n\n";
		
	errorMessage += "Stato server:\n" + e.status + " " + e.statusText + 
		                "\n\nTesto risposta server:\n" + e.responseText;
    alert(errorMessage);
}

