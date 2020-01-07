/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Paar.java:
 *  - Dit programma maakt Paren aan
 *	- Dit programma zet twee getallen om naar een paar object
 *  - Dit programma zet paren om naar een String
 *	- In dit programma staat een vergelijking voor paren uitgewerkt
 *  - Dit programma soorteerd paren op volgorde van machten.
 *  - Dit programma heeft de Coef en Macht aanroepbaar gemaakt
 *
 *	- Invoer: 	Twee getallen (Double en int)
 */
class Paar implements Comparable<Paar> {
	private double coef;
	private int macht;

	Paar(double coef, int macht) {
		this.coef = coef;
		this.macht = macht;
	}

	/* Methode van de Interface Collections, soorteert de Paren
	 * door positie te verhogen zelfde te laten of te veralgen*/
	public int compareTo(Paar that) {
		if (this.macht < that.macht) {
			return 1;
		}

		else if (this.macht == that.macht) {
			return 0;
		}

		return -1;
	}

	/* Methode van de Interface Collections, checkt of object een polynoom is
	 * vergelijkt of machten van paren het zelfde zijn en returned een boolean waarde*/
	public boolean equals(Object o) {
		if (! (o instanceof Paar)) {
			return false;
		}

		Paar n = (Paar) o;

		return (macht == n.macht) && (coef == n.coef);
	}

	/* Zet paren om naar een string*/
	public String toString() {
		/* Als Coefficient nul is dan kan het paar weggelaten worden*/
		if (coef == 0.0) {
			return "";
		}

		/* Als macht 0 is alleen coefficient returnen*/
		else if (macht == 0) {
			if (coef < 0.0) {
				return "" + Math.abs(coef);
			}

			else {
				return "" + coef;
			}
		}

		else if (coef == 1.0 || coef == -1.0) {
			return "x^" + macht;
		}

		/* Als coefficient negatief is absolute waarde returnen, - wordt in
		 * polynoom toString neergezet */
		else if (coef < 0.0) {
			return Math.abs(coef) + " x^" + macht;
		}

		return coef + " x^" + macht;
	}

	/* Coefficient aanroepbaar maken voor andere klassen*/
	public double getCoef(){
		return coef;
	}

	/* Macht aanroepbaar maken voor andere klassen*/
	public int getMacht(){
		return macht;
	}
}