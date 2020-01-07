/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Kamer.java:
 *	- Dit programma wordt aangeroepen vanuit Hotel.java
 *	- Dit programma vult een kamer met een gast als er wordt ingecheckt.
 *	- Dit programma leegt een kamer als er wordt uitgecheckt.
 *  - Het maakt een kamer printbaar.
 *
 *	- Invoer: 	Achternaam, Voornaam, Geboortedatum (formaat dd-mm-jjjj)
 *  - Uitvoer: 	Instructies voor inchecken, kamer vrij of gast string.
 */
import java.util.*;
class Kamer {
	Gast gast;
	Datum geboorteDatum;
	String voornaam, achternaam;

	/*Check iemand in door nieuwe gast en geboortedatum te maken*/
	public void checkIn() {
		do {
			System.out.print("Geef achternaam gast: ");
			this.achternaam = krijgInvoer();
		} while (achternaam.length() == 0);

		do {
			System.out.print("Geef voornaam gast: ");
			this.voornaam = krijgInvoer();
		} while (voornaam.length() == 0);

		System.out.print("Geef geboorteDatum gast [dd-mm-jjjj]: ");
		geboorteDatum = new Datum(krijgInvoer());
		gast = new Gast(achternaam, voornaam, geboorteDatum);
	}

	/*Zet gast op null en checkt op deze manier uit*/
	public void checkUit() {
		gast = null;
	}

	/*Vraag om invoer en return deze*/
	public String krijgInvoer() {
		Scanner invoer = new Scanner(System.in);

		if (invoer.hasNextLine()) {
			return invoer.nextLine().trim();
		}

		return "";
	}

	/*Kamer object naar String omzetten*/
	public String toString() {
		if (gast == null) {
			return "vrij";
		}

		else {
			return "" + gast;
		}
	}
}