/* 
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *	
 *	TestBreuken.java:
 *	- Dit programma berekent van twee Complexe getallen;
 *	- De som
 *	- Het verschil
 *	- Het product
 *	- Het quotient
 *	- De omgekeerde van een Complex getal
 *
 *	- Invoer: 	Een complexgetal (In de code zelf ingevoerd)
 *	- Uitvoer: 	De som, het verschil, product, quotient, de omgekeerde
 *				of een combinatie van bovenstaande.
 *	- Gebruik: 	java TestComplexeGetallen
 */

public class TestComplexeGetallen {
	public static void main(String[] args) {
		ComplexGetal a = new ComplexGetal (5.0 , 6.0);
		ComplexGetal b = new ComplexGetal ( -3.0 , 4.0);

		System.out.println("Voor de complexe getallen; a = " + a + " en b = " + b);
		System.out.println("b + a = " + b.telop(a));
		System.out.println("a - b = " + a.trekaf(b));
		System.out.println("a * b = " + a.vermenigvuldig(b));
		System.out.println("b * a = " + b.vermenigvuldig(a));
		System.out.println("a / b = " + a.deel(b));
		System.out.println("(a / b) * b = " + a.deel(b).vermenigvuldig(b));
		System.out.println("Omgekeerde van a = " + a.omgekeerde());
		System.out.println("Omgekeerde van b = " + b.omgekeerde());
	}
}