class Breuk implements BreukInterface {
	int teller, noemer;

	/*Breuk vereenvoudigen. Indien negatief, tijdelijk positief maken voor berekening ggd*/
	Breuk(int t, int n) {
		int ggd;

		if (n < 0) {
			n = n * -1;
			t = t * -1;
		}

		ggd = ggd(t, n);

		this.teller = t / ggd;
		this.noemer = n / ggd;
	}

	Breuk(int t) {
		this.teller = t;
		this.noemer = 1;		
	}

	Breuk() {
		this.teller = 0;
		this.noemer = 1;
	}

	Breuk(Breuk original) {
		new Breuk(this.teller, this.noemer);
	}

	public Breuk telop(Breuk b2) {
		int nieuweteller = (teller * b2.noemer) + (b2.teller * noemer);
		int nieuwenoemer = noemer * b2.noemer;
		Breuk r = new Breuk(nieuweteller, nieuwenoemer);
		return r;
	}

	public Breuk trekaf(Breuk b2) {
		int nieuweteller = (teller * b2.noemer) - (b2.teller * noemer);
		int nieuwenoemer = noemer * b2.noemer;
		Breuk r = new Breuk(nieuweteller, nieuwenoemer);
		return r;
	}

	public Breuk vermenigvuldig(Breuk b2) {
		int nieuweteller = teller * b2.teller;
		int nieuwenoemer = noemer * b2.noemer;
		Breuk r = new Breuk(nieuweteller, nieuwenoemer);
		return r;
	}

	public Breuk deel(Breuk b2) {
		b2 = b2.omgekeerde();
		Breuk r = this.vermenigvuldig(b2);
		return r;
	}

	public Breuk omgekeerde() {
		int nieuweteller = noemer;
		int nieuwenoemer = teller;
		Breuk r = new Breuk(nieuweteller, nieuwenoemer);
		return r;
	}

	public String toString() {
		String breukzin;

		if (noemer == 1){
			breukzin = Integer.toString(teller);
			return breukzin;
		}

		breukzin = teller + "/" + noemer;
		return breukzin;
	}
	
	/*Code GGD bereken via; http://introcs.cs.princeton.edu*/ 
	static int ggd(int t, int n) {
		if (t < 0) {
			t = t * -1;
		}

		while (t != 0) {
            int temp = t;
            t = n % t;
            n = temp;
        }

        return n;
	}
}