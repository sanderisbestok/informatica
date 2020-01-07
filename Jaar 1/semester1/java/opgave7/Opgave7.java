/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Opgave7.java:
 *	- Dit programma roept verschillende functies op met een ingevoerde datum.
 *	- Dit programma kan invoer ontvangen
 *	- Dit programma catch'ed foutmeldingen
 *
 *	- Invoer: 	Twee data en een interval
 *	- Uitvoer: 	Uitkomsten van berekeningen met data.
 *
 *	- Gebruik: 	java Opgave7
 */
import java.util.*;
import java.lang.*;
public class Opgave7 {
	static Datum datum, datum2;
	static Interval interval;

	/*main methode dient als console*/
	public static void main(String[] args) {
		boolean herhaal = false;
		while (herhaal == false) {
			/*Foute invoer wordt opgevangen*/
			try {
				System.out.print("Geef een datum (dd-mm-jjjj) op: ");
				datum = new Datum(krijgInvoer());
				herhaal = true;
			} catch (Exception e1) {
				System.out.println(e1.getMessage());
			}
		}

		herhaal = false;
		while (herhaal == false) {
			try {
				System.out.print("Geef twee jaren (jjjj-jjjj) op: ");
				interval = new Interval(krijgInvoer());
				herhaal = true;
			} catch (Exception e2) {
				System.out.println(e2.getMessage());
			}
		}

		System.out.println("\n" + datum.dag.getDag() + " " + datum.maand.toString()
		+ " is een zondag in de volgende jaren:");
		datum.zondagJaren(interval);

		System.out.println("\n\nDe volledige datum is: " + datum);

		System.out.print("\nHet weeknummer is: " );
		datum.weekNummer();

		herhaal = false;
		while (herhaal == false) {
			try {
				System.out.print("\nGeef een tweede datum (dd-mm-jjjj) op: ");
				datum2 = new Datum(krijgInvoer());
				herhaal = true;
			} catch (Exception e1) {
				System.out.println(e1.getMessage());
			}
		}

		System.out.print("\nTotaal aan jaren: ");
		datum.aantalJaren(datum2);
		System.out.println(" jaren");

		System.out.print("Totaal aan maanden: ");
		datum.aantalMaanden(datum2);
		System.out.println(" maanden");

		System.out.print("Totaal aan weken: ");
		datum.aantalWeken(datum2);
		System.out.println(" weken");

		System.out.print("Totaal aan dagen: ");
		datum.aantalDagen(datum2);
		System.out.println(" dagen");

		System.out.println("\n(Deze aantallen zijn naar beneden afgerond)");
	}

	/*Methode die invoer binnen krijgt en returned*/
	public static String krijgInvoer() {
		Scanner invoer = new Scanner(System.in);

		if (invoer.hasNextLine()) {
			return invoer.nextLine().trim();
		}

		return "";

	}
}