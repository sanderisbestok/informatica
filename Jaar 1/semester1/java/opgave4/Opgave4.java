/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *	Debugged versie van: dr. Quakerjack
 *
 *  - Opgave4.java:
 *	- Dit programma houdt een database bij van ingevoerde DNA sequences
 *	- Het programma kan verschillende functies uitvoeren met DNA sequences
 *  -
 *
 *	- Invoer: 	Een DNA sequence (evt zouden ook andere sequences gebruikt kunnen worden)
 *	- Uitvoer: 	Resultaat van opgegeven commando's.
 *	- Gebruik: 	java Opgave4
 */
import java.util.ArrayList;
import java.util.Scanner;
import java.io.IOException;

public class Opgave4 {
	public static ArrayList<String>	database;

	public static void main(String[] args) {
		System.out.println("Welcome to DNA Matcher v1.0");
		System.out.println("Type 'help' for a list of commands\n");
		database = new ArrayList<String>();
		executeConsole();
	}

	/*Invoer verkrijgen uit console*/
	public static String getInput() {
		Scanner input = new Scanner(System.in);
		return input.nextLine();
	}

	/*User interface, vraagt om invoer, en verwerkt deze door andere methodes aan te roepen
	indien invoer onjuist, foutmelding weergeven*/
	public static void executeConsole() {
		boolean quit = false;

		while (quit == false) {
			System.out.print("console> ");
			String invoer = getInput();
			/*Zin op delen in woorden*/
			String[] invoerString = invoer.split("\\s");
			String command = invoerString[0].toLowerCase();

			if (command.equals("help")) {
				helpUser();
			}

			else if (command.equals("list")) {
				listDatabase();
			}

			else if (command.equals("add")) {
				if (invoerString.length <= 1) {
					System.out.println("Please give at least one argument");
				}

				else {
					addToDatabase(invoerString[1]);
				}
			}

			else if (command.equals("remove")) {
				if (invoerString.length <= 1) {
					System.out.println("Please give at least one argument");
				}

				else if (database.contains(invoerString[1])) {
					removeFromDatabase(invoerString[1]);
				}

				else {
					System.out.println(invoerString[1] + " not in database, nothing done");
				}
			}

			else if (command.equals("compare")) {
				if (invoerString.length <= 2) {
					System.out.println("We need at least two strings for comparison");
				}

				else {
					compareStrings(invoerString[1], invoerString[2]);
				}
			}

			else if (command.equals("retrieve")) {
				if (invoerString.length <= 1) {
					System.out.println("Please give at least one argument");
				}

				else {
					search(invoerString[1]);
				}
			}

			else if (command.equals("quit")) {
				quit = true;
			}

			else if (command.equals("")) {
				System.out.println("No command given");
			}

			else {
				System.out.println("Command unknown, please enter valid command...");
			}
		}
	}

	/*Print de bestaande commands uit*/
	public static void helpUser() {
		System.out.println("LIST OF COMMANDS");
		System.out.print("	list");
		System.out.println("		Print database");
		System.out.print("	add ...");
		System.out.println("		Add to database");
		System.out.print("	compare ... ...");
		System.out.println("	Compare two strings");
		System.out.print("	retrieve ...");
		System.out.println("	Find in database");
		System.out.print("	quit");
		System.out.println("		Stop the program");
		System.out.print("	help");
		System.out.println("		Print this text\n");
	}

	/*Print de inhoud van de database uit*/
	public static void listDatabase() {
		System.out.println("");
		for (String s : database) {
			System.out.println(s);
		}

		System.out.println();
	}

	/*Voeg ingevoerde string toe aan database*/
	public static void addToDatabase(String i) {
		database.add(i);
	}

	/*Verwwijder ingevoerde*/
	public static void removeFromDatabase(String i) {
		database.remove(database.indexOf(i));
	}

	/*Vergelijk twee ingevoerde strings*/
	public static void compareStrings(String a, String aa)     {
		System.out.println("Difference = " + levensthein(a, aa, true));
	}

	/* Het levenshtein Algoritme is overgenomen van
	 * https://en.wikibooks.org/wiki/Algorithm_Implementation/Strings/Levenshtein_distance#Java
	 * Dit algoritme vergelijkt twee Strings en kijkt hoeveel aanpassingen er nodig zijn
	 * en returned dit*/
	public static int levensthein(String lhs, String rhs, boolean c) {
		 int[][] distance = new int[lhs.length() + 1][rhs.length() + 1];

        for (int i = 0; i <= lhs.length(); i++) {
            distance[i][0] = i;
        }

        for (int j = 1; j <= rhs.length(); j++) {
        	distance[0][j] = j;
 		}

        for (int i = 1; i <= lhs.length(); i++) {
            for (int j = 1; j <= rhs.length(); j++) {
                distance[i][j] = minimum(
                        distance[i - 1][j] + 1,
                        distance[i][j - 1] + 1,
                        distance[i - 1][j - 1] + ((lhs.charAt(i - 1) == rhs.charAt(j - 1)) ? 0 : 1));
            }
        }

		if (c) {
			for (int l1 = 0; l1 <= lhs.length(); l1++) {
				for (int l2 = 0; l2 <= rhs.length(); l2++) {
					System.out.print(distance[l1][l2] + "  ");
				}

				System.out.println("\n");
			}
		}

		return distance[lhs.length()][rhs.length()];
	}

	/*Kleinste int berekenen*/
	private static int minimum(int a, int b, int c) {
        return Math.min(Math.min(a, b), c);
    }

	/* Zoek in de database naar de beste match en print deze*/
	public static void search(String input) {
		String[] databaseArray = new String[database.size()];
		database.toArray(databaseArray);
		int n = 0;
		int[] distance = new int[databaseArray.length];

		for (String s : database) {
			distance[n++] = levensthein(input, s, false);
		}

		/* Bubblesort algoritme om te kijken welke strings het best matchen met invoer;
		 * Algoritme van; http://en.wikibooks.org/wiki/Algorithm_Implementation/Sorting/
		 * Bubble_sort#Java*/
		for (int x = 0; x < databaseArray.length - 1; x++) {
			for (int y = 1; y < databaseArray.length - x; y++) {
				if (distance[y - 1] > distance[y]) {
					int temp1 = distance[y - 1];
					String temp2 = databaseArray[y - 1];
					distance[y - 1] = distance[y];
					distance[y] = temp1;
					databaseArray[y - 1] = databaseArray[y];
					databaseArray[y] = temp2;
				}
			}
		}

		System.out.println("Best matches: ");
		for (int i = 0; i < Math.min(3, databaseArray.length); i++) {
			System.out.println(distance[i] + "\t" + databaseArray[i]);
		}
	}
}