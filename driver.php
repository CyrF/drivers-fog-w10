<?php
/* driver.php, fait par cyril, version 1.1 */

$uploaddir = '/images/drivers/';
?><!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<style>
		/* vert:4CBF30 */
		/* gris240:f0f0f0 */
		/* gris200:c8c8c8 */
		
* {
  box-sizing: border-box;
  font: 1rem Inconsolata, monospace;
  text-shadow: 0 0 5px #c8c8c8
}
body{ background-color:black; }
.header {
  text-align:center;
  color:#f0f0f0;
}
/* decoupage de la page en 2 colonnes */
.container-main {
  width: 60%;
  float: left;
  padding: 15px;
}
.container-help {
  width: 40%;
  float: left;
  padding: 15px;
}
.content-title {	/* titre de bloc en contraste inversé */
  width: 100%;
  float: left;
  padding: 5px;
  background-color:#f0f0f0;
  font-weight:bold;
  text-align:center;
  box-shadow: 0 0 5px #c8c8c8;
}
.content-box {	/* bordure de bloc */
  width: 100%;
  float: left;
  padding: 10px;
  border: 1px solid #f0f0f0;
  color:#f0f0f0;
  box-shadow: 0 0 5px #c8c8c8;
}
.content-blank {	/* séparateur */
  width: 100%;
  float: left;
  padding: 10px;
}
.button {	/* bouton avec ombre portée */
  background-color: black;
  border: 1px solid #f0f0f0;
  color: #f0f0f0;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  box-shadow: 8px 8px #f0f0f0; 
}
.label-file {
    cursor: pointer;
    color: #f0f0f0;
    
}
a:hover, .label-file:hover { color: #ffffff; font-weight: bold;}
.input-file { display: none; }
.table-list { width:100%; }
#overlay {	/* conteneur popup */
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 2;
  cursor: crosshair;
}
#outerbox{	/* marge noire autour du message popup */
  background: black;padding: 10px 18px 18px 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
}
.msg-inform{
  color: #f0f0f0;
   border: 1px solid #f0f0f0;
   box-shadow: 8px 8px #f0f0f0; padding: 30px 100px;
}
.msg-error{
  color: red;
   border: 1px solid red;
   box-shadow: 8px 8px red; padding: 30px 100px;
}
@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  [class*="container-"] {
    width: 100%;
}
  [class*="msg-"] {
    padding: 10px 20px;
  }  
}
a {
	text-decoration:none;
	color:#f0f0f0;
}
		</style>
	</head>
	<body>
		<div class="header">
			<pre>
   ___      _                    _      ___         __                 ___  ___       
  / _ \____(_)  _____ _______   | | /| / (_)__  ___/ /__ _    _____   <  / / _ \      
 / // / __/ / |/ / -_) __(_-<   | |/ |/ / / _ \/ _  / _ \ |/|/ (_-<   / /_/ // /      
/____/_/ /_/|___/\__/_/ /___/   |__/|__/_/_//_/\_,_/\___/__,__/___/  /_/(_)___/       </pre>
		</div>

		<div class="container-main">
			<div class="content-title">
				Ajouter ou remplacer un package
			</div>
			<div class="content-box">
				Format accepté: .tar.gz<br>
				Taille maxi supportée par PHP: <?php echo ini_get('post_max_size') ?><br><br>
				
				<form enctype="multipart/form-data" action="#" method="post">
				  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo 3000*1024*1024; ?>" />
				  <!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
				  <label for="file" class="label-file">> Selection du package de drivers a uploader</label><br>
				  <input id="file" name="driversfile" type="file" style="display:none" onchange="changebutton()" accept=".tar.gz" /><br>
				 <center> <input id="button" type="submit" class="button" value="Envoyer le fichier" onclick="on()" /></center><br>
				</form>
			
			</div>
			<div class="content-blank">
				&nbsp;
			</div>
			<div class="content-title">
				Drivers sur le serveur
			</div>
			<div class="content-box">
<?php
$aDrv = scandir($uploaddir);

echo '				<table class="table-list">';
foreach($aDrv as $file)
{
        if (substr($file, 0, 1) !== ".") { echo '					<tr><td><a href="./drivers/'. $file .'">'. $uploaddir . $file ."</a></td><td>" .  my_formatsize(filesize($uploaddir . $file)) . '</td><td>'. date ("F d Y H:i:s.", filemtime($uploaddir . $file)) . '</td></tr>';
}}
echo '				</table>';
?>
			</div>
		</div>

		<div class="container-help">
			<div class="content-title">
				Need help? Press F1 to not show more.
			</div>
			<div class="content-box">
---- Préparation des packages de pilotes ----<br>
<br>
Télécharger et décompresser les drivers-packs du fabricant, ou exécuter le script export_driver.ps1<br><br>
Renommer le dossier de pilotes du nom du modèle (respecter la casse). La commande suivante permet de connaître le modèle du poste:<br>
>	wmic csproduct get name<br><br>
Recompresser les pilotes au format .tar.gz, pour réduire le temps du transfert. <br>Sous Windows 10, la commande est:<br>
>	cd /d "dossier-parent-des-pilotes"<br>
>	tar czf "modele.tar.gz" "modele"<br>
<br>
---- Copie des pilotes sur le serveur fog ---<br>
<br>
Utiliser le formulaire sur cette page<br>http://srv-image/driver.php<br>
ou transférer avec winscp sur le srv-image, <br>dans le dossier /images/drivers<br>
<br>
---- Déploiement ----<br>
<br>
Les drivers sont injectés par FOG. Une fois que partimage a fini de restaurer les partitions, fog exécute les scripts postdownload avant le redémarrage:<br>
- celui pour w10 lit depuis le bios le nom du modèle et décompresse le fichier tar.gz correspondant dans le dossier c:/windows/drivers<br>
			</div>
		</div>
		
		<div id="overlay" onclick="on()">
			<div id="outerbox">
<?php
If ( isset($_POST['MAX_FILE_SIZE']) ) {
	$uploadfile = $uploaddir . basename($_FILES['driversfile']['name']);

	if (move_uploaded_file($_FILES['driversfile']['tmp_name'], $uploadfile)) {
			echo "				<div class='msg-inform'>
			Envoi terminé.
			</div>";
	} else {
			echo "				<div class='msg-error'>
			Une erreur est survenue.
			</div>";
	}
}
?>		

				<div class="msg-error" id="msedge" style="display:none">
				Your browser will not be able to send the file, then try to fill the main memory with the data, even fail to doing so, leading to a system crash. <br>
				Avoid the hassle, use a proper one or send your files directly with winscp.
				</div>
			</div>
		</div>
		
	<script>
function on() {
  document.getElementById("overlay").style.display = "block";
}

function off() {
  document.getElementById("overlay").style.display = "none";
}
function changebutton() {
  var value = document.getElementById("file").value;
  document.getElementById("button").value = "Envoyer " + value.replace('C:\\fakepath\\', '');
}

/* Affiche un message d'erreur en cas d'utilisation de edge */
var isIE = window.navigator.msPointerEnabled;
var isEdge = navigator.appVersion.indexOf("Edge") !== -1
if (isIE || isEdge) {
	document.getElementById("overlay").style.display = "block";
	document.getElementById("msedge").style.display = "block";
}
	</script>
<i>(Version 1.1)</i>
	</body>
</html>
<?php
function my_formatsize($size)
{
	/**
	* Permet de formater la taille numérique en octets ($size)  sous format texte.
	* Divise la taille par catégorie Octale, Kilo-octale, Méga-octale, Giga-octale.
	* @param $size est la taille numérique récupérée qui sera traitée.
	* @return $format la taille sous format texte.
	*/

	// Assignation de l'echelle de sortie
	$type='octets';

	// Giga-octets
	if ($size >= (1024*1024*1024)) { $size=$size/(1024*1024*1024); $type='Go';}
	// Mega-octets
	if ($size >= (1024*1024)) {$size=$size/(1024*1024); $type= 'Mo';}
	// Kilo-octets
	if ($size >= 1024) {$size=$size/1024; $type= 'Ko';}

	// Le résultat est traduit en entier
	$size=number_format($size, 2, ',', ' ');
	$format = $size.' '.$type;
	return $format;
}
?>
