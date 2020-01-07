/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	Polynoom.java:
 *  - Dit programma kan Polynoom objecten aanmaken
 *	- Dit programma zet paren getallen om naar een String van polynomen
 *  - Dit programma controleerd en sorteerd de polynomen
 *	- In dit programma staan de wiskunde operatie methoden met Polynomen uitgewerkt
 *  - Dit programma kan een polynoom omzetten naar een string.
 *
 *	- Invoer: 	String met getallen of ArrayList met paren
 *	- Uitvoer: 	Foutmeldingen indien foutieve invoer
 */
import java.util.*;
import java.io.*;

class Polynoom implements PolynoomInterface {
	private ArrayList<Paar> termen;

	/* Maak polynoom mbv bestand*/
	Polynoom(String filenaam) {
		termen = new ArrayList<Paar>();
		leesPolynoom(filenaam, termen);
		Collections.sort(termen);
		vereenvoudig(termen);
		termenCheck(termen);
	}

	/* Maak polynoom van een bestaande arraylist*/
	Polynoom(ArrayList<Paar> termen) {
		this.termen = termen;
		Collections.sort(termen);
		vereenvoudig(termen);
	}

	/* Leest polynoom uit bestand*/
	private static void leesPolynoom(String filenaam, ArrayList<Paar> termen) {
		/* Kijkt of bestand bestaat*/
		try {
			Scanner invoer = new Scanner(new File(filenaam));

			/* Maak paren van invoer en maak van deze paren polynoom*/
			while (invoer.hasNext()) {
				Double eerste = invoer.nextDouble();

				if (invoer.hasNextInt()) {
					int tweede = invoer.nextInt();
					Paar paar = new Paar(eerste, tweede);

					termen.add(paar);
				}

				/* Indien polynomen niet goed gegeven (oneven) return error en sluit af*/
				else {
					System.out.println("Oneven aantal getallen in: " + filenaam +
					" het programma wordt afgesloten");
					System.exit(0);
				}

			}

			invoer.close();
		}

		/* Bestaat bestand niet of zit er een fout in, geef error en sluit programma af*/
		catch (IOException e) {
			System.out.println("Er zit een fout in het bestand het programma wordt afgesloten");
			System.exit(0);
		}
	}

	/* Telt twee Polynomen bij elkaar op*/
	public Polynoom telop(Polynoom that) {
		ArrayList<Paar> rekenTermen = new ArrayList<Paar>();

		rekenTermen.addAll(this.termen);
		rekenTermen.addAll(that.termen);
		return new Polynoom(rekenTermen);
	}

	/* Trekt twee Polynomen van elkaar af*/
	public Polynoom trekaf(Polynoom that) {
		ArrayList<Paar> rekenTermen = new ArrayList<Paar>();

		for (int i = 0; i < (that.termen.size()); i++) {
			int nieuweMacht = that.termen.get(i).getMacht();
			double nieuweCoef = that.termen.get(i).getCoef() * -1;
			rekenTermen.add(new Paar(nieuweCoef, nieuweMacht));
		}

		rekenTermen.addAll(this.termen);
		return new Polynoom(rekenTermen);
	}

	/* Vermenigvuldigd twee polynomen met elkaar*/
	public Polynoom vermenigvuldig(Polynoom that) {
		ArrayList<Paar> rekenTermen = new ArrayList<Paar>();

		/* Elke term van pol1 met elke term van pol2 laten vermenigvuldigen*/
		for (int i = 0; i < (this.termen.size()); i++) {
			for (int j = 0; j < (that.termen.size()); j++) {
				int nieuweMacht = this.termen.get(i).getMacht() + that.termen.get(j).getMacht();
				double nieuweCoef = this.termen.get(i).getCoef() * that.termen.get(j).getCoef();
				rekenTermen.add(new Paar(nieuweCoef, nieuweMacht));
			}
		}

		return new Polynoom(rekenTermen);
	}

	/* Differentieeer een polynoom*/
	public Polynoom differentieer() {
		ArrayList<Paar> rekenTermen = new ArrayList<Paar>();

		for (int i = 0; i < (this.termen.size()); i++) {
			int nieuweMacht = this.termen.get(i).getMacht() - 1;
			double nieuweCoef = this.termen.get(i).getCoef() * this.termen.get(i).getMacht();
			rekenTermen.add(new Paar(nieuweCoef, nieuweMacht));
		}

		return new Polynoom(rekenTermen);
	}

	/* Integreer een polynoom*/
	public Polynoom integreer() {
		ArrayList<Paar> rekenTermen = new ArrayList<Paar>();

		for (int i = 0; i < (this.termen.size()); i++) {
			int nieuweMacht = this.termen.get(i).getMacht() + 1;
			double nieuweCoef = this.termen.get(i).getCoef() / nieuweMacht;
			rekenTermen.add(new Paar(nieuweCoef, nieuweMacht));
		}

		/* Integratie constante 1*/
		rekenTermen.add(new Paar(1,0));

		return new Polynoom(rekenTermen);
	}

	/* Kijkt of object een polynoom is en vergelijkt deze met polynoom*/
	public boolean equals(Object o) {
		if (! (o instanceof Polynoom)) {
			return false;
		}

		Polynoom n = (Polynoom) o;

		return n.termen.equals(this.termen);
	}

	/* Kijkt of er iets in de polynoom staat*/
	private void termenCheck(ArrayList<Paar> termen) {
		if (termen.size() == 0) {
			System.out.println("Geen geldige inhoud in een van de bestanden," +
			" het programma wordt afgesloten");
			System.exit(0);
		}
	}

	/* Vereenvoudig de polynoom*/
	private void vereenvoudig(ArrayList<Paar> termen) {
		int nieuweMacht;
		double nieuweCoef;

		/* Indien machten van paar het zelfde zijn coefficienten bij elkaar optellen */
		for (int i = 0; i < (termen.size() - 1); i++) {

			if (termen.get(i).getMacht() == termen.get(i + 1).getMacht()) {
				nieuweMacht = termen.get(i).getMacht();
				nieuweCoef = termen.get(i).getCoef() + termen.get(i + 1).getCoef();
				termen.set(i + 1, new Paar(nieuweCoef, nieuweMacht));
				termen.remove(i);
				i--;
			}
		}

		/* Coeffecienten die 0 zijn verwijderen*/
		for (int i = 0; i < termen.size(); i++) {
			if (termen.get(i).getCoef() == 0.0) {
				termen.remove(i);
			}
		}
	}

	/* Zet polynoom om naar string*/
	public String toString() {
		String string = "";
		for (int i = 0; i < termen.size(); i++) {

			/* Zet - voor coefficient indien negatief is*/
			if ((termen.get(i).getCoef()) < 0)  {
					if (i == 0) {
						string += "-";
					}

					else {
						string += " - ";
					}
				}

			/* Zet + voor cofficient indien positief en niet het eerste getal*/
			else if (i != 0) {
				string += " + ";
			}

			string += termen.get(i);
		}

	return string;
	}
}