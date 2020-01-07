/* 
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *	
 *	Opgave2.java:
 *	- Dit programma geeft weer of een bepaalde zin een palindroom is.
 *	- De gebruiker voert een zin in.
 *	- Indien de zin geen karakters bevat krijgt de gebruiker een foutmelding.
 *	- De zin wordt gefilterd op de letters a t/m z de getallen 0 t/m 9 en de
 *	  spatie.
 *	- Indien na filtratie geen karakters krijgt de gebruiker een foutmelding.
 *	- De gebruiker krijgt een aantal gegevens over de zin.
 *	- De gebruiker krijgt te zien of de zin een palindroom is
 *	- De gebruiker krijgt een grafiek te zien met de frequenties van de karakters.
 *
 *	- Invoer: 	Een zin
 *	- Uitvoer: 	Hoeveelheid karakters, gefilterde zin, hoeveelheid karakters
 *			gefilterde zin, aantal woorden, aantal klinkers, of de zin
 *			een palindroom is, de frequentie van de karakters, de hoogste
 *			frequentie, stapgrootte in de grafiek, grafiek met frequentie
 *			van getallen.
 *	- Gebruik: 	java Opgave2 
 */

import java.util.*;

public class Opgave2 {
	public static void main(String[] args) {
		String invoer, gefilterdeZin;
		int[] frequentie;

		invoer = getInvoer();
		gefilterdeZin = filterInvoer(invoer);
		woordenKlinkerCount(gefilterdeZin);
		palindroomCheck(gefilterdeZin);
		frequentie = frequentie(gefilterdeZin);
		grafiek(frequentie);
	}

	/*Invoer vragen en invoer returnen naar main methode, indien geen invoer foutmelding*/
	static String getInvoer () {
		Scanner scan = new Scanner(System.in);
		String invoer = "";
		int lengte;

		System.out.println("Voer een zin in: ");
		if (scan.hasNextLine()) {
			invoer = scan.nextLine().trim();
		}

		if (invoer.equals("")) {
			System.out.println("Geen invoer!");
			System.exit(0);
		}
		
		lengte = invoer.length();
		System.out.println("De ongefilterde zin heeft " + lengte + " karakters.");

		return invoer;
	}

	/*Zin wordt gefiltered op karakters, en hoofdletters worden in kleine letters omgezet.
	 *indien na filteren 0 karakters, programma afsluiten. Indien meer dan 80 karakters,
	 *zin in korten.*/
	static String filterInvoer (String invoer) {
		String gefilterdeZin = "";
		int lengte;

		/*Karakters worden gefilterd en indien 'goed' karakter,
		toegevoegen aan gefilterde zin*/
		for (char c : invoer.toCharArray()) {
			if ((c >= 'a' && c <= 'z') || (c >= '0' && c <= '9') || (c == ' ')) {
				gefilterdeZin = gefilterdeZin + c;
			}

			/*Hoofdletters worden omgezet in kleine letters en
			toegevoegd aan gefilterde zin*/
			else if (c >= 'A' && c <= 'Z') {
				c = (char)(c + ('a' - 'A'));
				gefilterdeZin = gefilterdeZin + c;
			}
		}

		if (gefilterdeZin.equals("")) {
			System.out.println("De gefilterde zin heeft geen karakters," 
			+ " het programma wordt afgesloten.");
			System.exit(0);
		}

		else {
			lengte = gefilterdeZin.length();

			/*Als de zin te lang is wordt deze ingekort.*/
			System.out.println("De gefilterde zin is: ");
			if (lengte > 80) {
				char[] c = gefilterdeZin.toCharArray();
				for (int i = 0; i < 79; i++) {
					 System.out.print(c[i]);
				}
			System.out.println("...");
			}

			else {
			System.out.println(gefilterdeZin);
			}

			System.out.println("De gefilterde zin heeft " + lengte + " karakters.");
		}

		return gefilterdeZin;
	}
	
	/*Tellen hoeveel woorden en hoeveel klinkers in de gefilterde zin voorkomen*/
	static void woordenKlinkerCount (String gefilterdeZin) {
		int woorden = 1, klinkers = 0;

		for (char c : gefilterdeZin.toCharArray()) {
			if (c == ' ') {
				woorden++;
			}

			else if (c == 'a' || c == 'e' || c == 'i' || c == 'o' || c == 'u' || c == 'y') {
				klinkers++;
			}
		}

		System.out.println("De gefilterde zin heeft " + woorden + " woorden.");
		System.out.println("De gefilterde zin heeft " + klinkers + " klinkers.");
	}

	/*Er wordt gekeken of de zin zonder spaties een palindroom is
	 *en er wordt feedback gegeven.*/
	static void palindroomCheck (String gefilterdeZin) {
		String palindroomZin = "";
		int lengte;
		boolean palindroomCheck = false;

		/*Spaties worden er voor de palindroomcheck uitgefilterd*/
		for (char c : gefilterdeZin.toCharArray()) {
			if ((c >= 'a' && c <= 'z') || (c >= '0' && c <= '9')) {
				palindroomZin = palindroomZin + c;
			}
		}

		lengte = palindroomZin.length();

		/*Er wordt gecontroleerd of de dubbelgefilterde zin een palindroom is*/
		for (int i = 0; i < (lengte / 2); i++) {
			if (palindroomZin.charAt(i) != palindroomZin.charAt(lengte - i - 1)) {
				palindroomCheck = false;
			}

			else {
				palindroomCheck = true;
			} 
		}

		if (palindroomCheck == true) {
			System.out.println("De zin is een palindroom.");
		}

		else {
			System.out.println("De zin is geen palindroom.");
		}

	}

	/*De karakters worden in een array opgeslagen, de frequenties worden uitgeprint*/
	static int[] frequentie (String gefilterdeZin) {
		int[] frequentie = new int[37];
		int max;
				
		for (char c : gefilterdeZin.toCharArray()) {

			if (c >= 'a' && c <= 'z') {
				frequentie[c - 'a']++;
			}

			/*Om het getal 0 op plek 26 te krijgen, 
			 *moet er volgens de ASCII tabel 22 van worden afgetrokken*/
			else if (c >= '0' && c <= '9') {
				frequentie[c - 22]++;
			}

			/*Om de spatie op plek 36 te krijgen, 
			 *moet er volgens de ASCII tabel 4 bij worden opgeteld*/
			else if (c == ' ') {
				frequentie[c + 4]++;
			}
		}
		
		System.out.println("----------------------------------"
		+ "---------------------------------------");
		System.out.println("Ter controle de frequenties van alle karakters;");
		
		/*Net zo lang de frequenties uitprinten totdat het 38ste karakter bereikt is
		* de spatie is het 38ste karakter*/
		for (int i = 0; i < 37; i++) {
			System.out.print(frequentie[i] + " ");
		}
		
		return frequentie;
	}

	/*Hoogste waarde frequentie en stapgrootte bepalen en Grafiek printen*/
	static void grafiek (int[] frequentie) {
		int max = 0, stapGrootte = 0, maximaleHoogte = 7;

		/*Bepaalde van de hoogste waarde in de frequentie array dit doen tot gehele inhoud
		 *array is vergeleken. Daarna stapgrootte met deze waardebepalen*/
		for (int i = 0; i < frequentie.length; i++) {
			if (frequentie[i] > max) {
				max = frequentie[i];
			}
		}

		/*Om afrondingsfouten te voorkomen wordt er 1 bij de stapGrootte opgeteld*/
		stapGrootte = max / maximaleHoogte + 1;
		if (stapGrootte < 1) {
			stapGrootte = 1;
		}

		System.out.println();
		System.out.println("De hoogste frequentie is: " + max);
		System.out.println("We gebruiken stapgrootte: " + stapGrootte);
		System.out.println("----------------------------------"
		+ "---------------------------------------");

		/*Per regel laten loopen, zoveel regels als de maximale frequentie.*/
		for (int j = max; j > 0; j = j - stapGrootte) {
			/*De waardes van de frequentie checken, indien aanwezig * printen,
			 *Indien niet aanwezig spatie printen. Dit doen tot alle karakters
			 *geweest zijn.*/
			for (int k = 0; k < frequentie.length; k++) {
				if (frequentie[k] > j) {
					frequentie[k] = frequentie[k] - stapGrootte;
					System.out.print("* ");
				}

				else {
					System.out.print("  ");
				}
			}

			System.out.println();
		}
		
		System.out.println("a b c d e f g h i j k l m n o p q r s t u v"
		+ " w x y z 0 1 2 3 4 5 6 7 8 9  ");
	}
}
