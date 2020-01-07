# PAV LaTeX-*template*
In deze *repository* staan diverse LaTeX-*templates* die binnen de  
bacheloropleiding informatica van de UvA gebruikt worden.

## Bestanden
Naast deze README zijn er diverse bestanden in de *repository* te vinden.

### *Templates*
Er zijn sjablonen voor verschillende type opdrachten, ieder in een apart  
bestand. Deze zijn op dit moment beschikbaar voor de volgende soorten  
documenten:

* Samenvatting
* Presentatie
* Projectplan
* Technisch rapport
* Literatuuronderzoek
* Bachelorthesis
* Generiek

Dit laatste bestand is bruikbaar voor alle overige opdrachten. Daarnaast is er  
een sjabloon voor de thesis. Dit sjabloon maakt geen gebruik van `pav.sty`, maar  
heeft een eigen `cls`-bestand.

### Installatie
Het PAV pakket bestaat uit een aantal bestanden, te weten een `sty` bestand  
en een aantal logo's van de Universiteit van Amsterdam. Je kunt deze bestanden  
apart installeren volgens onderstaande instructies of je kunt het geheel  
installeren of updaten met het volgende commando:

    sudo make install

Mocht je het pakket willen verwijderen, dan kun je dat heel simpel doen met  
het volgende commando:  

    sudo make uninstall

#### Troubleshooting
Mochten er onverhoopt problemen ontstaan bij de installatie, dan volgen  
hieronder de commando's om de templates toch goed te laten werken.  

    sudo mkdir -p /usr/share/pavlatex
    sudo cp -r images classes templates /usr/share/pavlatex
	sudo cp createpav.sh /usr/bin/createpav.sh

### Gebruik
Om een nieuw project aan te maken, gebruik je het `createpav` commando. Je kunt  
hier ook een type template aan meegeven. Bijvoorbeeld:  

    createpav -t rapport ~/mijn_mapje

Dit maakt een project aan volgens het rapport template in een mapje in je home  
directory. De map wordt automatisch aangemaakt als deze nog niet bestaat.  

#### Zonder installatie
Als je een nieuw LaTeX document wilt beginnen, kopieer je het template, de  
plaatjes en de class files naar een directory. Daarna kun je compilen en  
beginnen met werken!  

### .gitignore
LaTeX genereert vrij veel bestanden die niet gedeeld hoeven te worden. Werk je  
met LaTeX in een git *repository*, zet dit `.gitignore` bestand er dan ook in.  

## Potentiële verbeteringen
Op een aantal aspecten kunnen de templates nog verbeterd worden. Hieronder staat  
een overzicht van punten.

* De stijl van de bachelorthesis in lijn brengen met overige documenten.

## Auteurs

Een eerste versie van dit document is gemaakt door Robert van Wijk  
(robertvanwijk@uva.nl), met vergaande aanpassingen door Stephan van Schaik,  
Willem Vermeulen en Stephen Swatman.