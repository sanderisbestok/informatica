/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Maand.java:
 *	- Dit programma maakt maand object
 *	- Dit programma checkt of de maand bestaat
 *  - Dit programma zet het getal van de maand om naar een string
 *
 *	- Invoer: 	Maand
 *
 */
class Maand {
	private int maand;

	/*Maakt een maandobject aan*/
	Maand (int maand) {
		this.maand = maand;
	}

	/*Methode kijkt of de maand bestaat*/
	public static void checkMaand(int maand) {
		if (maand > 12) {
			throw new IllegalArgumentException("Geef een geldige maand op");
		}
	}

	/*Returned de maand als een string*/
	public String toString() {
		String[] maandenArray = {"januari", "februari", "maart", "april", "mei",
		"juni", "juli", "augustus", "september", "oktober", "november", "december"};

		return maandenArray[this.maand - 1];
	}
}