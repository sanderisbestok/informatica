class ComplexGetal implements ComplexGetalInterface {
	double a, b;

	ComplexGetal(double a, double b) {
		this.a = a;
		this.b = b; 
	}

	public ComplexGetal telop(ComplexGetal c2) {
		double nieuwea = a + c2.a;
		double nieuweb = b + c2.b;
		ComplexGetal r = new ComplexGetal(nieuwea, nieuweb);
		return r;
	}

	public ComplexGetal trekaf(ComplexGetal c2) {
		double nieuwea = a - c2.a;
		double nieuweb = b - c2.b;
		ComplexGetal r = new ComplexGetal(nieuwea, nieuweb);
		return r;
	}

	public ComplexGetal vermenigvuldig(ComplexGetal c2) {
		double nieuwea = (a * c2.a) - (b * c2.b);
		double nieuweb = (a * c2.b) + (b * c2.a);
		ComplexGetal r = new ComplexGetal(nieuwea, nieuweb);
		return r;
	}

	public ComplexGetal deel(ComplexGetal c2) {
		double nieuwea = ((a * c2.a) + (b * c2.b)) / ((c2.a * c2.a) + (c2.b * c2.b));
		double nieuweb = ((b * c2.a) - (a * c2.b)) / ((c2.a * c2.a) + (c2.b * c2.b));
		ComplexGetal r = new ComplexGetal(nieuwea, nieuweb);
		return r;
	}

	public ComplexGetal omgekeerde() {
		double nieuwea = a / ((a * a) + (b * b));
		double nieuweb = ((-1) * b) / ((a * a) + (b * b));
		ComplexGetal r = new ComplexGetal(nieuwea, nieuweb);
		return r;
	}

	public String toString() {
		String complexezin = a + " + " + b + "i";
		return complexezin;
	}
}