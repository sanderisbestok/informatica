/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *	
 *	Deel2.java:
 *	- Dit programma berekent de som van zowel de oneven getallen als de even getallen
 *	  van een ingevoerd getal.
 *	- Vervolgens berekent dit programma het verschil tussen deze twee sommen.
 *	- Het getal moet worden opgegeven in de Command-line.
 *	- Het programma controleert of de invoer goed is.
 *
 *	- Invoer: 	Een geheel en positief getal
 *	- Uitvoer: 	3 oplossingen
 *	- Gebruik: 	java Deel2 getal
 */
public class Deel2 {
	public static void main(String[] args) {
		int a, even, oneven, verschil;
		a = Integer.parseInt(args[0]);
		even = 0;
		oneven = 0;
		
		/* Er wordt gecontroleerd of het ingevoerde getal wel positief is */
		if (a <= 0) {
			System.out.println("Let op! Het ingevoerde getal moet positief zijn");
		}

		else {		
			/* Som van even getallen wordt berekent */
			for (int i = 0; i <= a; i = i + 2){
			even = even + i;
			}

			/* Som van oneven getallen wordt berekent */
			for (int i = 1; i <= a; i = i + 2){
			oneven = oneven + i;
			}

			verschil = even - oneven;
			System.out.println("De som van oneven getallen tot en met " + a + " is " + oneven);
			System.out.println("De som van even getallen tot en met " + a + " is " + even);
			System.out.println("Het verschil tussen de twee sommen is " + verschil);
		}
	}
}
