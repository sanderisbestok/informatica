/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Gast.java:
 *	- Dit programma wordt aangeroepen vanuit Kamer.java
 *	- Het slaat de drie strings op van een gast, en zet dit om naar een printbare string.
 */
class Gast {
	String voornaam, achternaam;
	Datum geboorteDatum;

	/*Maak nieuwe gast aan met voornaam, achternaam en geboortedatum*/
	Gast (String achternaam, String voornaam, Datum geboorteDatum) {
		this.achternaam = achternaam;
		this.voornaam = voornaam;
		this.geboorteDatum = geboorteDatum;
	}

	/*Zet gast object om naar string*/
	public String toString() {
		return achternaam + ", " + voornaam + " " + geboorteDatum;
	}
}