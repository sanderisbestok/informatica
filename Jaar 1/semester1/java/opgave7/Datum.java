/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Datum.java:
 *	- Dit programma check of een datum op de juiste manier is ingevoerd
 *	- Berekeningen met data worden in dit programma gedaan.
 *	- Het programma kan Dag Maand en Jaar objecten aanmaken.
 *  - Het getal van de dag wordt in dit programma omgezet in een string.
 *  - Datum wordt omgezet naar String.
 *
 *	- Invoer: 	Datum
 *	- Uitvoer: 	Uitkomsten van berekeningen
 */
import java.util.*;
class Datum {
	int jaarGetal, maandGetal, dagGetal, jaarVerschil;
	Dag dag;
	Maand maand;
	Jaar jaar;

	/* Constructor maakt datum object aan*/
	Datum (String datum) {
		/* De patroonCheck komt uit Opgave5.java; deze hebben we verkregen
		 * vanuit de opdracht.*/
		String patroon = "\\d{2}-\\d{2}-\\d{4}";
		boolean patroonCheck = datum.matches(patroon);

		if (patroonCheck) {
			String datumSplit[] = datum.split("-");
			this.jaarGetal = Integer.parseInt(datumSplit[2].trim());
			this.maandGetal = Integer.parseInt(datumSplit[1].trim());
			this.dagGetal = Integer.parseInt(datumSplit[0].trim());

			/* Als er een datum als 00-00-0000 wordt ingevoerd, foutmelding gooien*/
			if (dagGetal == 0 || maandGetal == 0 || jaarGetal == 0) {
				throw new InputMismatchException("Foute invoer, probeer opnieuw.");
			}

			/* Er wordt van te voren gecheckt of de Jaar Maand Dag objecten aangemaakt kunnen
			 * worden dit gebeurd omdat dit de enige plek is waar dit momenteel 'mooi' kan. Anders
			 * zou aan de constructor van de dag de maanden en jaren meegegeven moeten worden
			 * om het constant te houden is dit bij jaar maand en dag gedaan.*/
			jaar.checkJaar(jaarGetal);
			this.jaar = new Jaar(jaarGetal);

			maand.checkMaand(maandGetal);
			this.maand = new Maand(maandGetal);

			dag.checkDag(dagGetal, maandGetal, jaar.getSchrikkelJaar());
			this.dag = new Dag(dagGetal);
		}

		else {
			throw new InputMismatchException("Foute invoer, probeer opnieuw.");
		}
	}

	/* Maak van een datum een String*/
	public String toString() {
		return dagString() + " " + dag + " " + maand + ", " + jaar;
	}

	/* Koppelt de waarde van de dag aan een string*/
	private String dagString() {
		String[] dagenArray = {"Zondag", "Maandag", "Dinsdag", "Woensdag", "Donderdag",
		"Vrijdag", "Zaterdag"};

		int jaarGetal = this.jaarGetal;
		int maandGetal = this.maandGetal;
		int dagGetal = this.dagGetal;
		int dagInt = dagBerekening(jaarGetal, maandGetal, dagGetal);

		return dagenArray[dagInt];
	}

	/* Kijkt voor elk jaar binnen de interval of de datum op een zondag valt*/
	public void zondagJaren(Interval interval) {
		int[] intervalArray = interval.getInterval();
		int maandGetal = this.maandGetal;
		int dagGetal = this.dagGetal;

		for (int i = intervalArray[0]; i <= intervalArray[1]; i++) {
			int dagInt = dagBerekening(i, maandGetal, dagGetal);

			if (dagInt == 0) {
				System.out.print(i + " ");
			}
		}
	}

	/* Berekening van het weeknummer met algoritme van wikipedia: https://goo.gl/whZAWV*/
	public void weekNummer() {
		int ordinalDate, dagInt, weekNummer;

		ordinalDate = ordinalDate();
		dagInt = dagBerekening(this.jaarGetal, this.maandGetal, this.dagGetal);

		/* Voor deze berekening moet zondag 7 zijn*/
		if (dagInt == 0) {
			dagInt = 7;
		}

		weekNummer = (ordinalDate - dagInt + 10) / 7;

		System.out.println(weekNummer);
	}

	/* Berekent de waarde van de dag, algoritme en berekining van Wikepedia;
	 * https://goo.gl/r51w9r*/
	private int dagBerekening(int jaarGetal, int maandGetal, int dagGetal) {
		int dagInt;

		if (maandGetal < 3) {
			dagGetal += jaarGetal--;
		}

		else {
			dagGetal += jaarGetal - 2;
		}

		dagInt = (23 * maandGetal / 9 + dagGetal + 4
		+ jaarGetal / 4 - jaarGetal / 100 + jaarGetal / 400 ) % 7;

		return dagInt;
	}

	/* Bereken het verschil in aantal jaren*/
	public void aantalJaren(Datum that) {
		jaarVerschil = this.jaarGetal - that.jaarGetal;

		/*Tweede datum was chronologisch eerder*/
		if (jaarVerschil > 0) {
			if ((this.maandGetal - that.maandGetal) < 0) {
				jaarVerschil = jaarVerschil - 1;
				System.out.print(jaarVerschil);
			}

			else if (jaarVerschil == 0) {
				if ((this.dagGetal - that.dagGetal) < 0) {
					jaarVerschil = jaarVerschil - 1;
					System.out.println(jaarVerschil);
				}
			}

			else {
				System.out.print(jaarVerschil);
			}
		}

		/*Eerste datum was chronologisch eerder*/
		else if (jaarVerschil < 0) {
			if ((this.maandGetal - that.maandGetal) > 0) {
				jaarVerschil = jaarVerschil + 1;
				System.out.print(Math.abs(jaarVerschil));
			}

			else if (jaarVerschil == 0) {
				if ((this.dagGetal - that.dagGetal) > 0) {
					jaarVerschil = jaarVerschil + 1;
					System.out.print(Math.abs(jaarVerschil));
				}
			}

			else {
				System.out.print(Math.abs(jaarVerschil));
			}
		}

		else {
			System.out.print("0");
		}
	}

	/*Berekent het aantal maanden tussen twee datums*/
	public void aantalMaanden(Datum that) {
		int maandVerschil = this.maandGetal - that.maandGetal;

		if (maandVerschil > 0) {
			maandVerschil = maandVerschil + (Math.abs(jaarVerschil * 12));

			if (this.dagGetal < that.dagGetal) {
				maandVerschil = maandVerschil -1;
			}
		}

		else if (maandVerschil < 0) {
			maandVerschil = Math.abs(maandVerschil) + (Math.abs(jaarVerschil * 12));

			if (this.dagGetal > that.dagGetal) {
				maandVerschil = maandVerschil -1;
			}
		}

		else {
			maandVerschil = Math.abs(jaarVerschil * 12);
		}

		System.out.print(maandVerschil);
	}

	/*Berekent het aantal weken tussen twee datums*/
	public void aantalWeken(Datum that) {
		int aantalDagen, aantalWeken;

		aantalDagen = this.aantalDagenBerekening(that);

		aantalWeken = aantalDagen / 7;

		System.out.print(aantalWeken);
	}

	/*Print hoeveelheid dagen*/
	public void aantalDagen(Datum that) {
		int aantalDagen;

		aantalDagen = this.aantalDagenBerekening(that);

		System.out.print(aantalDagen);
	}


	/* Berekent de hoeveelheid dagen tussen twee data*/
	private int aantalDagenBerekening(Datum that) {
		int aantalDagen = 0;
		int dagenInJaar = 365;
		int dagenInSchrikkeljaar = 366;

		/*Indien tweede datum eerder dan eesrte datum is*/
		if (this.jaarGetal > that.jaarGetal || (this.jaarGetal == that.jaarGetal && this.maandGetal > that.maandGetal)
		|| (this.jaarGetal == that.jaarGetal && this.maandGetal == that.maandGetal && this.dagGetal > that.dagGetal)) {
			/*Aantaldagen in het eerste jaar*/
			if (that.jaar.getSchrikkelJaar()) {
				aantalDagen = aantalDagen + dagenInSchrikkeljaar - that.ordinalDate();
			}

			else {
				aantalDagen = aantalDagen + dagenInJaar - that.ordinalDate();
			}

			/*Aantaldagen in tussenstaande jaren*/
			for (int i = that.jaarGetal + 1; i < this.jaarGetal; i++) {
				Jaar j = new Jaar(i);

				if (j.getSchrikkelJaar()) {
					aantalDagen = aantalDagen + dagenInSchrikkeljaar;
				}

				else {
					aantalDagen = aantalDagen + dagenInJaar;
				}
			}

			/*Aantal dagen in laatste jaar*/
			aantalDagen = aantalDagen + this.ordinalDate();
		}

		else if (this.jaarGetal == that.jaarGetal && this.maandGetal == that.maandGetal && this.dagGetal == that.dagGetal) {
			aantalDagen = 0;
		}

		/*Indien eerste datum eerder dan tweede datum is*/
		else {
			/*Aantaldagen in het eerste jaar*/
			if (this.jaar.getSchrikkelJaar()) {
				aantalDagen = aantalDagen + dagenInSchrikkeljaar - this.ordinalDate();
			}

			else {
				aantalDagen = aantalDagen + dagenInJaar - this.ordinalDate();
			}

			/*Aantaldagen in tussenstaande jaren*/
			for (int i = this.jaarGetal + 1; i < that.jaarGetal; i++) {
				Jaar j = new Jaar(i);

				if (j.getSchrikkelJaar()) {
					aantalDagen = aantalDagen + dagenInSchrikkeljaar;
				}

				else {
					aantalDagen = aantalDagen + dagenInJaar;
				}
			}

			/*Aantal dagen in laatste jaar*/
			aantalDagen = aantalDagen + that.ordinalDate();
		}

		return aantalDagen;
	}

	/*Berekent ordinalDate; https://goo.gl/whZAWV*/
	private int ordinalDate() {
		int[] ordinalDateArray = {0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334};
		int ordinalDate;

		if (jaar.getSchrikkelJaar()) {
			for (int i = 2; i < ordinalDateArray.length; i++) {
				ordinalDateArray[i]++;
			}
		}

		ordinalDate = ordinalDateArray[this.maandGetal - 1] + this.dagGetal;
		return ordinalDate;
	}
}