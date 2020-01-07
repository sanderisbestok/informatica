/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	TestPolynoom.java:
 *	- Dit programma kan verschillende wiskundige operaties uitvoern met polynomen.
 *	- Het kan optellen, aftrekken, vermenigvuldigen, differentieren en integreren.
 *	- Het programma kan twee polynomen vergelijken
 *
 *	- Invoer: 	Twee bestanden gevuld met getallen met de naam polynoom1 en polynoom2.
 *	- Uitvoer: 	Uitkomst van verschillende berekeningen met Polynomen
 *
 *	- Gebruik: 	java TestPolynoom
 */
class TestPolynoom {
		public static void main(String[] args) {
			Polynoom pol1, pol2, som, verschil, product, diff1, diff2, int1,
			int2, orig;

			pol1 = new Polynoom("polynoom1");
			System.out.println("polynoom1:			" + pol1);
			pol2 = new Polynoom("polynoom2");
			System.out.println("polynoom2:			" + pol2);

			som = pol1.telop(pol2);
			System.out.println("som:				" + som);
			verschil = pol1.trekaf(pol2);
			System.out.println("verschil:			" + verschil);

			product = pol2.vermenigvuldig(pol1);
			System.out.println("product:			" + product);

			diff1 = pol1.differentieer();
			System.out.println("differentieer pol 1: 		" + diff1);
			diff2 = pol2.differentieer();
			System.out.println("differentieer pol 1: 		" + diff2);

			int1 = pol1.integreer();
			System.out.println("integreer pol 1:		" + int1);
			int2 = pol2.integreer();
			System.out.println("integreer pol 2:		" + int2);


			/* Testen van differentieer- en integreer-methode*/
			orig = pol1.differentieer().integreer();
			System.out.print("differentieer dan integreer pol 1: " + orig);
			if (orig.equals(pol1)) {
				System.out.println(" (is gelijk aan origineel");
			}

			else {
				System.out.println(" (is niet gelijk aan origineel)");
			}

			orig = pol1.integreer().differentieer();;
			System.out.print("integreer dan differentieer pol 1: " + orig);
			if (orig.equals(pol1)) {
				System.out.println(" (is gelijk aan origineel");
			}

			else {
				System.out.println(" (is niet gelijk aan origineel)");
			}

			orig = pol2.differentieer().integreer();
			System.out.print("differentieer dan integreer pol 2: " + orig);
			if (orig.equals(pol2)) {
				System.out.println(" (is gelijk aan origineel");
			}

			else {
				System.out.println(" (is niet gelijk aan origineel)");
			}

			orig = pol2.integreer().differentieer();
			System.out.print("integreer dan differentieer pol 2: " + orig);
			if (orig.equals(pol2)) {
				System.out.println(" (is gelijk aan origineel");
			}

			else {
				System.out.println(" (is niet gelijk aan origineel)");
			}
		}
}