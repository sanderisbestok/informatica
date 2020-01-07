/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Hotel.java:
 *	- Dit programma wordt aangeroepen vanuit Opgave5.java
 *	- Het weergeeft de status van de kamers en het aantal gasten.
 *	- Het kijkt of kamers vrij zijn en weergeeft dit.
 *  - Het programma werkt aantal gasten bij en roept check in/uit methodes op
 *
 *	- Invoer: 	De kamer waarin een gast heeft geslapen
 *  - Uitvoer: 	Status van het hotel, kamerstatus, in en uit check messages.
 */
import java.util.*;
class Hotel {
	Kamer[] kamers;
	int aantalGasten;

	/*Maak een hotel aan met i(consoleinvoer) aantal kamers*/
	Hotel(int aantalKamers) {
		kamers = new Kamer[aantalKamers];

		for (int i = 0; i < aantalKamers; i++) {
			kamers[i] = new Kamer();
		}
	}

	/*Print alle kamers, of deze vol zijn en de hoeveelheid gasten*/
	public void statusCheck() {
		System.out.println("Status van dit hotel");
		for (int i = 0; i < kamers.length; i++) {
			System.out.println("Kamer " + (i + 1) + ": " + kamers[i]);
		}

		System.out.println("Aantal gasten: " + aantalGasten);
	}

	/*Check iemand in indien kamer vrij, aantal gasten verhogen*/
	public void checkIn() {
		int kamerCheck = kamerCheck();

		if (kamerCheck == -1) {
			System.out.println("Er zijn helaas geen kamers vrij.");
		}

		else {
			this.aantalGasten++;
			System.out.println("Er is een kamer vrij.");
			kamers[kamerCheck].checkIn();
			System.out.println(kamers[kamerCheck] + " is succesvol ingecheckt.");
		}
	}

	/*Checkt iemand uit (kamer object leegmaken), indien geldig kamernummer opgegeven, aantal gasten verlagen*/
	public void checkUit() {
		System.out.print("In welke kamer heeft de gast geslapen? ");
		int invoer = krijgInvoer();

		if (kamers[invoer].gast != null) {
			aantalGasten--;
			kamers[invoer].checkUit();
			System.out.println("Succes vol uitgecheckt");
		}

		else {
			System.out.println("Er heeft geen gast in kamer " + invoer + " geslapen.");
		}
	}

	/*Check of de kamers vrij zijn*/
	public int kamerCheck() {
		for (int i = 0; i < kamers.length; i++) {
			if (kamers[i].gast == null) {
				return i;
			}
		}

		return -1;
	}

	/*returned de invoer voor checkout, kamer nummer -1 == voor goede plek op kamerarray*/
	public int krijgInvoer() {
		Scanner invoer = new Scanner(System.in);
			return invoer.nextInt() - 1;
	}
}