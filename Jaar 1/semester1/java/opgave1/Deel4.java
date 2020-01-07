/* 
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *	
 *	Deel4.java:
 *	- Dit programma weergeeft n aantal lucas getallen.
 *	- De gebruiker voert een waarde voor n in.
 *	- Als de gebruiker een te groot of een negatief getal invoert,
 *	  krijgt deze een foutmelding.
 *
 *	- Invoer: 	Een natuurlijk getal, kleiner dan 46.
 *	- Uitvoer: 	n aantal lucasgetallen of negatieve feedback indien foute invoer. 
 *	- Gebruik: 	java Deel4 
 */
import java.util.*;

public class Deel4 {
	public static void main(String[] args) {
		int invoer, lucas, lucas1, lucas2;
		lucas1 = 1;
		lucas2 = 2;
		Scanner scanner = new Scanner(System.in);
		
		System.out.print("Geef een natuurlijk getal: ");
		invoer = scanner.nextInt();

		/*Controleren of invoer positief en niet te groot is*/
		if (invoer < 0) {
			System.out.println("Het getal moet positief zijn!");		
		}
		
		else if (invoer > 45) {
			System.out.println("Het getal is te groot, dit past niet!");		
		}
		
		/*n aantal lucasgetallen berekenen*/
		else {
			System.out.println("De eerste " + invoer + " Lucas-getallen zijn:");			
			System.out.print("2 1 ");
			for (int i = 2; i < invoer; i++) {
			lucas = lucas1 + lucas2;
			System.out.print(lucas + " ");
			lucas2 = lucas1;
			lucas1 = lucas;
			}		
		}	
	}
}
