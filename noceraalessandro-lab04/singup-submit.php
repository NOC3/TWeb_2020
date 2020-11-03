<?php
    $set = true;
    foreach (array_keys($_POST) as $e){
        if($_POST[$e]==null){
            $set = false;
            $what = $e;

        }
    }
    if($set==true){
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $pers = $_POST['Personality'];
        $os = $_POST['OS'];
        $minage = $_POST['minage'];
        $maxage = $_POST['maxage'];
        
        $mex = '<strong>Thank you!</strong><br>
        Welcome to NerdLuv, <?= $name?> !
        Now <a href="matches.php">log in to see your matches</a>';

        if($name!=null and $gender!=null and $age!=null and $pers!=null and $os!=null and $minage!=null and $maxage!=null ){
            $text =$name.",".$gender.",".$age.",".$pers.",".$os.",".$minage.",".$maxage."\n";
            file_put_contents("singles.txt", $text, FILE_APPEND);
        }

    }else{
        $mex = "ATTENZIONE! Parametri mancanti";
    }
    
?>

<?php include "top.html"; ?>

<?= $mex?>


<?php include "bottom.html"; ?>