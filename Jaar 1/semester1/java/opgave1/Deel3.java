/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *	
 *	Deel3.java:
 *	- Dit programma laat de gebruiker een getal raden tussen de 1 en 10.
 *	- De gebruiker voert een getal in terwijl het programma een random getal genereert.
 *	- De gebruiker heeft drie pogingen om het getal te raden en krijgt feedback 
 *	  of het getal te groot of te klein is.
 *	- Het programma checkt of de invoer goed is.
 *	- Het programma is zo gemaakt dat het relatief makkelijk is om zowel het bereik
 *	  als het aantal pogingen aan te passen.
 *
 *	- Invoer:	Een getal tussen de 1 en 10
 *	- Uitvoer: 	Uitslag of het getal geraden is; en hulp bij het raden indien dit niet
 *	  		het geval is. Na drie pogingen de oplossing laten zien.
 *	- Gebruik:	java Deel3 
 */
import java.util.*;

public class Deel3 {
	public static void main(String[] args) {
		int invoer, getal, verloren = 0;
		Random random = new Random();
		Scanner scanner = new Scanner(System.in);

		/*Genereer random getal tussen de 1 en de 10*/
		getal = random.nextInt(10) + 1;
	
		for (int i = 1; i < 4; i++) {
			/*Instructie; alleen weer laten geven voor de eerste poging*/		
			if (i == 1) {
				System.out.println("Geef een getal tussen van 1 tot en met 10, je mag drie keer raden; ");
			}
			
			/*Systeem vraagt om input aan gebruiker*/
			System.out.print("Poging " + i + ": ");
			invoer = scanner.nextInt();
					
			/*Controleren of de invoer tussen de 1 en de 10 ligt. Zo niet; programma afbreken*/
			if (invoer < 1 || invoer > 10) {
				System.out.println("Het getal was niet tussen 1 en 10, dan stop ik.");
				i = i + 3;
			}
		
			/*Controleren of de invoer gelijk is aan het te raden getal. Indien waar; programma afbreken*/
			else if (invoer == getal) {
				System.out.println("Gewonnen!");
				i = i + 3;
			}

			/*Controleren of de invoer te groot of te klein was en hiervan melding weergeven*/
			else {
				if (invoer < getal && verloren < 2) {
					System.out.println("Helaas, het getal is te klein.");
					verloren++;
				}
			
				else if (verloren < 2) {
					System.out.println("Helaas, het getal is te groot.");
					verloren++;
				}
				
				/*Indien het na 3 pogingen nog niet geraden is; programma afbreken*/
				else {
					System.out.println("Helaas, je hebt verloren. Het getal was: " + getal);
				}
			}
		}
	}
}




