/* 
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *	
 *	TestBreuken.java:
 *	- Dit programma berekent van twee Complexe breuken;
 *	- De som
 *	- Het verschil
 *	- Het product
 *	- Het quotient
 *	- De omgekeerde van een Complexe breuk
 *
 *	- Invoer: 	Een paar Complexe breuken (In de code zelf ingevoerd)
 *	- Uitvoer: 	De som, het verschil, product, quotient, de omgekeerde
 *				of een combinatie van bovenstaande.
 *	- Gebruik: 	java TestComplexeGetallen
 */
public class TestComplexeGetallen {
	public static void main(String[] args) {
		ComplexGetal a = new ComplexGetal (5, 3, 1, 2);
		ComplexGetal b = new ComplexGetal (1 , 6, -1, 3);

		System.out.println("Voor de complexe breuken; a = " + a + " en b = " + b);
		System.out.println("a + b = " + a.telop(b));
		System.out.println("a - b + b = " + (a.trekaf(b).telop(b)));
		System.out.println("(a - b) + (b - a) = " + (a.trekaf(b)).telop(b.trekaf(a)));
		System.out.println("a * b = " + a.vermenigvuldig(b));
		System.out.println("a / b = " + a.deel(b));
		System.out.println("(a / b) * b = " + a.deel(b).vermenigvuldig(b));
		System.out.println("(a / b) * (b / a) = " + (a.deel(b)).vermenigvuldig(b.deel(a)));
		System.out.println("Omgekeerde van a = " + a.omgekeerde());
		System.out.println("Omgekeerde van a * a = " + a.omgekeerde().vermenigvuldig(a));
	}
}