/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Jaar.java:
 *	- Dit programma maakt een jaar object
 *	- Dit programma checkt het jaar verwerkt kan worden (groter dan 1754)
 *  - Dit programma checkt of een jaar een schrikkeljaar is
 *
 *	- Invoer: 	Jaar
 *
 */
class Jaar {
	private int jaar;

	/*Maakt jaar object aan*/
	Jaar (int jaar) {
		this.jaar = jaar;
	}

	/*Methode checkt of het jaar boven de 1754 is*/
	public static void checkJaar(int jaar) {
		if (jaar <= 1754) {
			throw new IllegalArgumentException("Geef een jaartal boven 1754 op");
		}
	}

	/*Methode die kijkt of het jaar een schrikeljaar is*/
	public boolean getSchrikkelJaar() {
		if (((this.jaar % 4) == 0) && ((this.jaar % 100) != 0)) {
			return true;
		}

		else if (((this.jaar % 400) == 0)) {
			return true;
		}

		return false;
	}

	/*Zet jaar om naar String*/
	public String toString() {
		return "" + this.jaar;
	}
}