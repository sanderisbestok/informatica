#! /bin/bash

#Startup geeft een uitleg van het spel en vraagt om de naam
startup() {
	#Verwijder map van vorige spel, en pak mapstructuur uit
	rm -r -f a
	tar -x -f map.tar
	homefolder="$PWD"
	rm "bericht"
	touch "bericht"
	clear

	echo "Welkom bij Minedir"
	echo
	echo "Dit spel heeft geen duidelijk doel. Het is ook wel de uselessbox onder de games."
	echo
	echo "Je draagt in dit spel een tas bij je. Samen met deze tas ga je op reis. Op reis,"
	echo "door een landschap van folders."
	echo
	echo "Folders? Wat moet ik nou weer met papieren folders?"
	echo "Kom op, je studeert informatica met folders bedoelen we natuurlijk mappen. In"
	echo "deze mappen bevinden zich letters. Jawel dat lees je goed letters! Deze"
	echo "letters kun je verzamelen. Eigenlijk is het dus een soort virtuele speurtocht."
	echo
	echo "Als je 16 dezelfde letters verzameld heb, kan je een nieuwe map aan maken, maar"
	echo -e "\e[31mlet op! \e[39mDit kan alleen als de map nog niet bestaat in de map waar"
	echo "je je bevindt."
	echo
	echo "Voor de beste ervaring moet je speel je het met een verticaal zo groot mogelijke"
	echo "terminal"
	echo
	echo "Spannend he? Vinden wij nou ook dus als je er klaar voor bent kunnen we beginnen"
	echo
	echo "Begin door jezelf een naam te geven:"

	#vraagt om naam
	while [[ ${#naam} -eq 0 ]]
	do
		read -r naam
	done

	if [ -f $naam ]; then
		rm "$naam"
	fi

	touch "${naam}"
}

#Interface keert elke keer terug, met een bericht over vorige actie en informatie
interface() {
	clear
	functie=""
	taak=""

	#Check of je je in hoofdmap bevindt, dan is alleen navigeren mogelijk
	if [[ "$(basename $PWD)" == "${homefolder##*/}" ]]; then
		cat "$homefolder/bericht"
		echo "$naam je bevindt je momenteel in de Hoofdmap"
		echo -e "Je kunt momenteel alleen navigeren met behulp van \e[31mmove [map] \e[39m"
		echo
		echo "Je kunt navigeren naar;"
		echo
		echo "Beneden:"
		#Code om backslash weg te halen via http://goo.gl/ykLgZ9
		ls -d */ | sed 's#/##'
		echo

		functies
	fi

	#Laat bericht zien (Bericht is feedback van functies)
	cat "$homefolder/bericht"
	echo
	echo "Je bevindt je momenteel in $(basename $PWD)"
	echo "hier liggen hier de volgende letters:"
	cat ".resources"
	echo
	echo "Je kunt hier een aantal acties uitvoeren;"
	echo -e "Je kunt navigeren met behulp van \e[31mmove [map] \e[39m"
	echo -e "Je kunt letters op pakken door \e[31mget [lettercombi] \e[39mte gebruiken"
	echo -e "Je kunt letters droppen in de huidige map met \e[31mdrop [front|back] \e[39m"
	echo -e "Je kunt een folder aanmaken met \e[31mmake\e[39m, maar dit kan alleen als je"
	echo "16 dezelfde letters heb waarvan nog geen map bestaat!"
	echo -e "Als je er klaar mee bent kun je aflsuiten met \e[31mquit\e[39m"

	#Inhoudt wordt vaker gebruikt DRY
	inhoudberekening

	#Inhoud van tas bepalen
	if [[ "$inhoudgetal" == 0 ]]; then
		echo
		echo "Je tas is leeg..."
	else
		echo
		echo -n "Het volgende zit in je tas: "
		cat "$homefolder/$naam"
	fi

	echo
	echo
	#Kijken waar heen te navigeren
	echo "Je kunt navigeren naar;"
	opa="$(cd ../; basename $PWD)"
	if [[ "$opa" != "${homefolder##*/}" ]]; then
		echo
		echo "Boven:"
		echo "$opa"
	fi

	echo
	#Variabele voor check of er een directory beneden is
	#Eventuele error wordt onderdrukt
	beneden="$(ls -d */ 2> /dev/null)"

	if [[ "$beneden" != "" ]]; then
		echo "Beneden:"
		#Code om backslash weg te halen via http://goo.gl/ykLgZ9
		ls -d */ | sed 's#/##'
		echo
	fi

	functies
}

#Berekent de inhoud van de tas en berekent mogelijk toekomstige inhoud
inhoudberekening() {
	inhoud=$(<"$homefolder"/"$naam")
	inhoudgetal="${#inhoud}"
	inhoudgetal2="${#taak}"
	inhoudgetal3=$(($inhoudgetal+$inhoudgetal2))
}

#Functies vraagt de gebruiker een commanda in te voeren en roept deze aan.
functies() {
	while [[ ${#functie} -eq 0 ]]
	do
		read -r functie taak
	done

	echo

	if [[ "$functie" == "move" && "$taak" == [a-d] ]]; then
		move
	elif [[ "$functie" == "get" ]]; then
		get
	elif [[ "$functie" == "drop" ]] && [[ "$taak" == "front" || "$taak" == "back" ]]; then
		drop
	elif [[ "$functie" == "make" ]]; then
		make
	elif [[ "$functie" == "quit" ]]; then
		clear
		echo "  ____  _  __    _____   ____  ______ _____ "
		echo " / __ \| |/ /   |  __ \ / __ \|  ____|_   _|"
 		echo "| |  | | ' /    | |  | | |  | | |__    | |  "
 		echo "| |  | |  <     | |  | | |  | |  __|   | |  "
 		echo "| |__| | . \ _  | |__| | |__| | |____ _| |_ "
		echo " \____/|_|\_(_) |_____/ \____/|______|_____|"
		sleep 3
		exit
	else
		echo -e "\e[31mGeen geldig commando\e[39m" > "$homefolder"/"bericht"

		interface
	fi
}

#Functie laat de speler verplaatsen
move() {
	#Kijken of map beneden bestaat zoja, verplaatsen
	if [[ -d ./"$taak" ]]; then
		cd ./"$taak"
		echo "We duiken de map in," > "$homefolder"/"bericht"
		echo
		cat ".resources"
	#Kijken of map boven bestaat zoja, verplaatsen
	elif [[ -d ../../"$taak" ]]; then
		cd ../../"$taak"
		echo "Nou dan gaan we maar weer naar boven" > "$homefolder"/"bericht"
		echo "Als het goed is heb je dit al gezien maar" >> "$homefolder"/"bericht"
		cat ".resources"
	else
		echo -e "\e[31mJe kan niet naar deze map navigeren\e[39m" > "$homefolder"/"bericht"
	fi

	interface
}

#Functie laat een speler resources pakken uit de map
get() {
	if grep -x -q "$taak" ".resources"; then

		inhoudberekening

		#Check of de inhoud van het bestand wel kleiner is dan 17
		if [[ "$inhoudgetal3" -lt 17 ]]; then
			echo -n "$taak" >> "$homefolder"/"$naam"
			#Verwijderen van resources uit bestand
			sed -i.bak "/$taak/d" .resources; rm .resources.bak
			echo "Je tasje is bijgevuld met $taak" > "$homefolder"/"bericht"
		else
			echo "Dit is te veel dit kan je tas niet aan" > "$homefolder"/"bericht"
		fi
	else
		echo -e "\e[31m$taak is niet aanwezig hier\e[39m" > "$homefolder"/"bericht"
	fi

	interface
}

#Deze functie verwijderd letters uit de tas en voegt ze toe aan resources
drop() {
	inhoudberekening

	if [[ $inhoud == "" ]]; then
		echo -e "\e[31mEr valt natuurlijk niks te droppen als je niks bij je hebt \
		\e39m" > "$homefolder"/"bericht"
	else
		#Voorkant net zolang een verwijderen tot er een andere letter is
		if [[ "$taak" == "front" ]]; then
			laatsteletter="${inhoud:0:1}"
			while [[ "$laatsteletter" == "${inhoud:0:1}" ]]; do
				inhoud="$(echo $inhoud | cut -c 2-)"
				verwijderd="$verwijderd""$laatsteletter"
			done

			echo "De voorkant is gedropt hoor" > "$homefolder"/"bericht"
			echo "$inhoud" > "$homefolder"/"$naam"
			echo "$verwijderd" >> .resources
		#Achterkant net zolang een verwijderen tot er een andere letter is
		elif [[ "$taak" == "back" ]]; then
			laatsteletter="${inhoud: -1}"
			while [[ "$laatsteletter" == "${inhoud: -1}" ]]; do
				inhoud="${inhoud::-1}"
				verwijderd="$verwijderd""$laatsteletter"
			done

			echo "De achterkant is gedropt hoor" > "$homefolder"/"bericht"
			echo "$inhoud" > "$homefolder"/"$naam"
			echo "$verwijderd" >> .resources
		else
			echo -e "Gebruik of \e[31mfront\e[39m of \e[31mback\e[39m achter drop. \
			" >	"$homefolder"/"bericht"

		fi
	fi

	interface
}

#Laat functie indien mogelijk nieuwe folder aanmaken
make() {
	inhoudberekening

	eersteletter="${inhoud:0:1}/"
	eersteletter2="${inhoud:0:1}"
	mappen="$(ls -d */ 2> /dev/null | tr "\n" " ")"
	opa="$(cd ../; basename $PWD)/"

	#Folder kan alleen aangemaakt worden als hij erboven of eronder niet bestaat
	#Folder in map met dezelfde naam kan wel!
	if grep "$eersteletter2\{16\}" "$homefolder/$naam"; then
		echo "16 letters matchen"
		if  [[ "$mappen" =~ "$eersteletter" ]]; then
			echo -e "\e[31mOeps\e[39m deze map bestaat al" > "$homefolder"/"bericht"
		else
			if [[ "$opa" =~ "$eersteletter" ]]; then
				echo -e "\e[31mVerdorie\e[39m, de opa van deze map heette ook al zo... \
				" > "$homefolder"/"bericht"
			else
				#Bij aanmaken nieuwe map resources vullen
				mkdir "$eersteletter"
				cd ./"$eersteletter"
				"$homefolder"/fill-resources.sh > .resources
				cd ../

				echo "" > "$homefolder"/"$naam"

				echo "De map $eersteletter is aangemaakt!" > "$homefolder"/"bericht"
			fi
		fi
	fi

	interface
}

startup
interface




