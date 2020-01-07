/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Dag.java:
 *	- Dit programma maakt een dag object
 *	- Dit programma checkt of een dag in een bepaalde maand bestaat
 *
 *	- Invoer: 	Dag
 *
 */
class Dag {
	private int dag;

	/*Maakt dagobject aan*/
	Dag (int dag) {
		this.dag = dag;
	}

	/*Methode kijkt of de dag wel bestaat, houd rekening met schrikkeljaren*/
	public static void checkDag(int dag, int maand, boolean schrikkeljaar) {
		int[] maandLengte = {31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31};

		if (schrikkeljaar && maand == 2) {
			if (dag > 29) {
				throw new IllegalArgumentException("Deze dag bestaat niet in deze maand");
			}

			return;
		}

		else if (dag > maandLengte[maand - 1]) {
			throw new IllegalArgumentException("Deze dag bestaat niet in deze maand");
		}
	}

	/*Returned het dagobject als een string*/
	public String toString() {
		return "" + this.dag;
	}

	public int getDag() {
		int dag = this.dag;

		return dag;
	}
}