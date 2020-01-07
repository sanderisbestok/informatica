/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Opgave5.java:
 *	- Dit programma is een eenvoudig hotel administratie systeem.
 *	- Het programma kan kamers vullen door mensen in te checken
 *	- De kamers kunnen geleegd worden door mensen uit te checken
 *  - Het programma kan de status van kamers laten zien.
 *  - Het programma weergeeft informatie over de ingecheckte personen.
 *
 *	- Invoer: 	De keuze 1, 2 ,3 , 4. (Bij elke keuze andere vervolginvoer)
 *	- Uitvoer: 	Informatie over de kamers in het hotel en personen die ingecheckt zijn.
 *
 *	- Gebruik: 	java Opgave5 aantalKamers
 */

import java.util.*;
public class Opgave5 {
	public static Datum vandaag = new Datum ("01-10-2015");
	public static void main(String[] args) {
		Hotel hotel = new Hotel(Integer.parseInt(args[0]));

		console(hotel);
	}

	/* Console weergeeft keuze mogelijkheden en zorgt ervoor dat de goede methode
	 * voor de bijbehorende keuze wordt aangeroepen.*/
	public static void console(Hotel hotel) {
		boolean quit = false;

		System.out.println("\nWelkom bij Hotel Administratie");

		do {
			System.out.println("\nKies uit [1] Statusoverzicht, [2] Gasten inchecken,"
			+ " [3] Gasten uitchecken, [4] Einde");
			int invoer = krijgInvoer();

			switch (invoer) {

				case 1:{
					hotel.statusCheck();
					break;
				}

				case 2: {
					hotel.checkIn();
					break;
				}

				case 3: {
					hotel.checkUit();
					break;
				}

				case 4: {
					System.out.println("Het programma wordt afgesloten");
					quit = true;
					break;
				}

				default: {
					System.out.println("Voert u alstublieft een geldige keuze in.");
					break;
				}
			}

		} while (quit == false);
	}

	/*Vraag om invoer en return deze*/
	public static int krijgInvoer() {
		System.out.print("Uw keuze: ");
		Scanner invoer = new Scanner(System.in);

		if (invoer.hasNextInt()) {
			return invoer.nextInt();
		}

		else {
			return 0;
		}
	}

}