
<!DOCTYPE html>
<?php
	$film_name = $_GET["film"];
	$dir = $film_name."/";
	$info = file($dir."info.txt");
	$info_name = $info[0];
	$info_year = $info[1];
	$info_rate = $info[2];
		
	//setto la copertina del film
	$overview = file($dir."overview.txt");
	$overview_png_path = $dir."overview.png" ;

	//setto l'immagine di rate
	if($info_rate>=60){
		$evaluation_img = "https://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/freshbig.png";
	}else{
		$evaluation_img = "https://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rottenbig.png";
	}

	//setto quali review vanno dove
	$rev_str = $dir."review*.txt";
	$review = glob($rev_str);
	$tot_rev_num = count($review);
	$rev_num = ceil($tot_rev_num/2);
	$left_review = array_slice($review, 0, $rev_num);
	$right_review = array_slice($review, $rev_num);

		
	?>
<html lang="it">
	<head> 
		<!-- nome della pagina dipende dal nome del film-->
		<title> <?= $info_name?> - Rancid Tomatoes</title>
        <link href="http://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rotten.gif" type="image/gif" rel="icon">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="movie.css" type="text/css" rel="stylesheet">
	</head>

    <body>  
		<div id = "banner">
			<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/banner.png" alt="Rancid Tomatoes">
		</div>
                
        <!-- Titolo variabile-->  
        <h1> <?= $info_name." ".$info_year ?> </h1>
                
        <div id = "main">
            <div id = "right">
				<div>
			        <!-- copertina film -->  
					<img src="<?= $overview_png_path?>" alt="general overview">
				</div>
                    
				<dl>
        			<!-- dati di overview -->  
					<?php
						for($i = 0; $i<count($overview); $i++){
							$overview_str = explode(":",$overview[$i]);
						?>	
						<dt><?=$overview_str[0]?><dt>
						<dd><?=$overview_str[1]?><dd>
					<?php	
						}
					?>
				</dl>
                   
            </div> 
            <div id = "left">
				<div id ="left-top">
					<!-- percentuale film -->	
					<img src=<?= $evaluation_img?> alt="Rotten">
                    <span class="evaluation"><?=$info_rate?>%</span>
				</div>
                <div id="columns">
                
					<div id="leftcolumn">  
						<!-- recensioni di sx -->
						<?php
							for($i=0; $i<5 and $i<count($left_review); $i++){
								$rev = file($left_review[$i]);
								$text_rev = $rev[0];
								$rev_img = "http://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/".str_replace("\n","",strtolower($rev[1])).".gif";
								$author = $rev[2];
								$publication = $rev[3];
								?>
						<p class="quotes">
                    		<span >
								<img src= <?=$rev_img?> alt="Rotten">
								<q> <?=$text_rev?> </q>
							</span>
						</p>

						<p class="reviewers">
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
							<?=$author?> <br>
                        	<span class="publications"><?=$publication?></span>
						</p>
							
						<?php
							}	
						?>

                    </div> 
                    <div id = "rightcolumn">
						<!-- recensioni di dx -->		
					<?php
							for($i=0; $i<5 and $i<count($right_review); $i++){
								$rev = file($right_review[$i]);
								$text_rev = $rev[0];
								$rev_img = "http://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/".str_replace("\n","",strtolower($rev[1])).".gif";
								$author = $rev[2];
								$publication = $rev[3];
								?>
						<p class="quotes">
                    		<span >
								<img src= <?=$rev_img?> alt="Rotten">
								<q> <?=$text_rev?> </q>
							</span>
						</p>

						<p class="reviewers">
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
							<?=$author?> <br>
                        	<span class="publications"><?=$publication?></span>
						</p>
							
						<?php
							}	
						?>

                    </div> 
                </div> 
            </div>
            
			<p id="bottom">(1-<?= $tot_rev_num?>) of <?= $tot_rev_num?></p>
            
        </div>
		<div id="validators">
			<a href="http://validator.w3.org/check/referer">
				<img width="88" src="https://upload.wikimedia.org/wikipedia/commons/b/bb/W3C_HTML5_certified.png " alt="Valid HTML5!">
			</a>			
			<br>
			<a href="http://jigsaw.w3.org/css-validator/check/referer">
				<img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!">
			</a>
		</div> 
	</body>
</html>
