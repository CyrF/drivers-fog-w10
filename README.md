# Paramétrage sur le master

Sur le master, créer un dossier **c:/Windows/Drivers/** (avec cette casse). 
Déposer le script de la région **import_drivers.ps1**

Vérifier que le script **C:/Windows/Setup/Scripts/SetupComplete.cmd** 
contient bien les commandes permettant de lancer l'installation des pilotes.

	REM IMPORT DES DRIVERS
	"powershell.exe" -executionpolicy bypass -noprofile -file "c:\Windows\Drivers\import_drivers.ps1"

	REM Attends la fin de l'installation des pilotes
	:WaitDrivers
	Timeout /t 120
	tasklist | find /i "powershell.exe" && Goto :WaitDrivers
	tasklist | find /i "pnputil.exe" && Goto :WaitDrivers

# Installation sur le serveur

Créer un dossier nommé **drivers** dans **/images/** 
avec les droits lecture/écriture pour tous.

	mkdir /images/drivers
	chmod 777 /images/drivers

Déposer le fichier **driver.php** dans le dossier **/var/www/**

Créer un lien symbolique nommé **drivers** 
dans **/var/www** pointant sur le dossier **/images/drivers**

	ln -s /var/www/drivers /images/drivers

Déposer le script **fog.insertionPilotes-win10** 
dans le dossier **/images/postdownloadscripts/**

Ajouter cette ligne à la fin du fichier **/images/postdownloadscripts/fog.postdownload**

	# attention, la ligne suivante commence bien par un point
	. ${postdownpath}fog.insertionPilotes-win10

# Ajout d'un pack de pilotes sur le serveur

Télécharger et décompresser les drivers-packs du fabricant, 
ou exécuter le script **export_driver.ps1**

Renommer si besoin le dossier de pilotes avec le nom du modèle, en respectant la casse. 
La commande suivante permet de connaître le modèle du poste:

	wmic csproduct get name

Recompresser les pilotes au format .tar.gz, par exemple **Optiplex 3060.tar.gz**, 
pour réduire le temps du transfert. Sous Windows 10, la commande est:

	cd /d "dossier-parent-des-pilotes"
	tar czf "modele.tar.gz" "modele"

Déposer l'archive en utilisant le formulaire sur la page http://srv-image/driver.php
ou la transférer avec winscp sur le srv-image dans le dossier **/images/drivers**

# Fonctionnement

Après avoir copier les partitions, Fog décompressera automatiquement
le fichier tar.gz correspondant au modèle dans le dossier **c:/Windows/Drivers**

A la fin du Sysprep, le script **import_drivers.ps1** sera lancé par **SetupComplete.cmd**
et installera les pilotes.
