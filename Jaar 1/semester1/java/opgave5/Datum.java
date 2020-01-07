/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Datum.java:
 *	- Dit programma wordt aangeroepen vanuit Opgave5.java en Kamer.java
 *	- Het checkt of de datum in goed formaat is gegeven.
 *	- Het kijkt of de datum geldig is.
 *  - Het checkt of iemand 18 jaar of ouder is.
 *
 *  - Uitvoer: 	Melding als geboortedatum verkeerd is ingevoerd
 */
class Datum {
	int dag, maand, jaar;

	/*Geboortedatum in int's opslaan indien goed formaat (dd-mm-jjjj) gegeven anders programma afsluiten*/
	Datum (String geboorteDatum) {
		String patroon = "\\d{2}-\\d{2}-\\d{4}";
		boolean datumCheck = geboorteDatum.matches(patroon);

		if (datumCheck) {
			String geboorteSplit[] = geboorteDatum.split("-");
			this.dag = Integer.parseInt(geboorteSplit[0].trim());
			this.maand = Integer.parseInt(geboorteSplit[1].trim());
			this.jaar = Integer.parseInt(geboorteSplit[2].trim());
			dagMaandCheck(dag, maand);
		}

		else {
			System.out.println("Geboortedatum is onjuiste formaat");
			System.exit(0);
		}
	}

	/*Zet geboortedatum om naar het juist print formaat (volwassen zonder * ander met*/
	public String toString() {
		boolean volwassen = volwassen(Opgave5.vandaag);
		if (volwassen) {
			return "(" + dag + "." + maand + "." + jaar + ")";
		}

		else {
			return "(" + dag + "." + maand + "." + jaar + ")*";
		}
	}

	/*Checkt of gast volwassen is en returned boolean*/
	public boolean volwassen(Datum vandaag) {
		if ((vandaag.jaar - this.jaar) > 18)  {
			return true;
		}

		else if (((vandaag.jaar - this.jaar) == 18) && ((vandaag.maand - this.maand) > 0)) {
			return true;
		}

		else if (((vandaag.jaar - this.jaar) == 18) && ((vandaag.maand - this.maand) == 0) &&
		((vandaag.dag - this.dag) >= 0)) {
			return true;
		}

		else {
			return false;
		}
	}

	/*Check of er wel geldige maand en dag is opgegeven*/
	public void dagMaandCheck(int dag, int maand) {
		if (dag > 31 || maand > 12) {
			System.out.println("Geen geldige datum gegeven");
			System.exit(0);
		}

		else {
			return;
		}
	}
}
