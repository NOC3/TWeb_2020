<?php include "top.html"; ?>
<?php
    function compatibile($single, $user){
        $s = explode(",",$single);
        if($s[1]!=$user[1] && $user[2]>$s[5] && $user[2]<$s[6] && $user[4]==$s[4]){
            $i=0;
            while($i<4 && $i <strlen($user[3]) && $i<strlen($s[3])){
                if($user[3][$i]==$s[3][$i]){
                    return true;
                }
                $i=$i+1;
            }
        }
    }

    function search_user($name){
        if(file_exists("singles.txt")){
            $singles = file("singles.txt");
            foreach($singles as $single){
                $s = explode(",",$single);
                if($s[0]== $name){
                    return $s;
                }
            }
        }else{
            print('<div style="color: red;" >FILE NON TROVATO</div>');
        }
    }

    $user = $_GET['name'];
    $match = [];
    $user_data = search_user($user);
    if(file_exists("singles.txt")){
        $singles = file("singles.txt");
        foreach($singles as $single){
            if(compatibile($single, $user_data)){
                array_push($match,$single);
            }
        }
    }else{
        print('<div style="color: red;" >FILE NON TROVATO</div>');
    }


?>
<strong>Matches for <?=$user?></strong>
<?php
    foreach($match as $u){
        $m = explode(",", $u);
    ?>


    <div class="match">
        <p >
            <img src=" http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/4/user.jpg">
            <?=$m[0]?>
        </p>
        <ul>    
            <li><strong>gender:</strong><?=$m[1]?></li>
            <li><strong>age:</strong><?=$m[2]?></li>
            <li><strong>type:</strong><?=$m[3]?></li>
            <li><strong>os:</strong><?=$m[4]?></li>
        </ul>
    </div>
    <?php    
    }

include "bottom.html"; ?>
