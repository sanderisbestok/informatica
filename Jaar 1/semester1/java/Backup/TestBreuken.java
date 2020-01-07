/* 
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *	
 *	TestBreuken.java:
 *	- Dit programma berekent van een breukenpaar;
 *	- De som
 *	- Het verschil
 *	- Het product
 *	- Het quotient
 *	- De omgekeerde van een breuk
 *
 *	- Invoer: 	Een breukenpaar (In de code zelf ingevoerd)
 *	- Uitvoer: 	De som, het verschil, product, quotient, de omgekeerde
 *				of een combinatie van bovenstaande.
 *	- Gebruik: 	java TestBreuken 
 */
public class TestBreuken {
	public static void main(String[] args) {
		Breuk a = new Breuk(1, 5);
		Breuk b = new Breuk(3, 4);
		
		System.out.println("Voor het breukenpaar: a = " + a + " en b = " + b);
		System.out.println("a + b = " + a.telop(b));
		System.out.println("a - b = " + a.trekaf(b));
		System.out.println("a - b + b = " + (a.trekaf(b)).telop(b));
		System.out.println("(a - b) + (b - a) = " + (a.trekaf(b)).telop(b.trekaf(a)));
		System.out.println("a * b = "+ a.vermenigvuldig(b));
		System.out.println("a / b = " + a.deel(b));
		System.out.println("(a / b) * b = " + b.vermenigvuldig(a.deel(b)));
		System.out.println("(a / b) * (b / a) = " + (a.deel(b)).vermenigvuldig(b.deel(a)));
		System.out.println("Omgekeerde van a = " + a.omgekeerde());
		System.out.println("a * omgekeerde van a = " + a.vermenigvuldig(a.omgekeerde()));
	}
}
