/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Interval.java:
 *	- Dit programma maakt een interval object
 *	- Dit programma zorgt dat een interval gereturned kan worden als Array
 *
 *	- Invoer: 	Interval
 *
 */
import java.util.*;
class Interval {
	int jaarGetal1, jaarGetal2;
	Jaar jaar1, jaar2;

	/*Maakt interval object aan (bestaande uit twee jaar objecten)*/
	Interval (String interval) {
		/* De patroonCheck komt uit Opgave5.java; deze hebben we verkregen
		 * vanuit de opdracht.*/
		String patroon = "\\d{4}-\\d{4}";
		boolean patroonCheck = interval.matches(patroon);

		if (patroonCheck) {
			String intervalSplit[] = interval.split("-");
			this.jaarGetal1 = Integer.parseInt(intervalSplit[0].trim());
			this.jaarGetal2 = Integer.parseInt(intervalSplit[1].trim());

			/* Checkt of het tweede jaar later is dan het eerste jaar, maakt jaar objecten aan
			 * of gooit een error*/
			if (this.jaarGetal1 < this.jaarGetal2) {
				jaar1.checkJaar(jaarGetal1);
				this.jaar1 = new Jaar(jaarGetal1);

				jaar2.checkJaar(jaarGetal2);
				this.jaar2 = new Jaar(jaarGetal2);
			}

			else {
				throw new InputMismatchException("Geef de jaren in chronologische volgorde op.");
			}
		}

		else {
			throw new InputMismatchException("Geef jaren volgens patroon op");
		}
	}

	/*Methode zorgt dat de interval aanroepbaar is buiten deze klasse*/
	public int[] getInterval() {
		int[] intervalArray = {this.jaarGetal1, this.jaarGetal2};

		return intervalArray;
	}
}