public class ComplexGetal implements ComplexGetalInterface {
	/*reele en imaginaire deel van de breuk apart, negatieve breuk*/
	Breuk re;
	Breuk im;

	ComplexGetal(int t1, int n1, int t2, int n2) {
		this.re = new Breuk(t1, n1);
		this.im = new Breuk(t2, n2);
	}

	ComplexGetal(Breuk a, Breuk b) {
		this.re = a;
		this.im = b;
	}

	public ComplexGetal telop(ComplexGetal c2) {
		Breuk reeel = re.telop(c2.re);
		Breuk imaginair = im.telop(c2.im);
		ComplexGetal r = new ComplexGetal(reeel, imaginair);
		return r;
	}

	public ComplexGetal trekaf(ComplexGetal c2) {
		Breuk reeel = re.trekaf(c2.re);
		Breuk imaginair = im.trekaf(c2.im);
		ComplexGetal r = new ComplexGetal(reeel, imaginair);
		return r;
	}

	public ComplexGetal vermenigvuldig(ComplexGetal c2) {
		Breuk reeel = (re.vermenigvuldig(c2.re)).trekaf(im.vermenigvuldig(c2.im));
		Breuk imaginair = (re.vermenigvuldig(c2.im)).telop(im.vermenigvuldig(c2.re));
		ComplexGetal r = new ComplexGetal(reeel, imaginair);
		return r;
	}

	public ComplexGetal deel(ComplexGetal c2) {
		c2 = c2.omgekeerde();
		ComplexGetal r = this.vermenigvuldig(c2);
		return r;
	}

	public ComplexGetal omgekeerde() {
		Breuk neg = new Breuk (-1, 1);
		Breuk reeel = re.deel((re.vermenigvuldig(re)).telop(im.vermenigvuldig(im)));
		Breuk imaginair = 
		(im.deel((re.vermenigvuldig(re)).telop(im.vermenigvuldig(im))).vermenigvuldig(neg));
		ComplexGetal r = new ComplexGetal(reeel, imaginair);
		return r;
	}

	public String toString() {
		String complexezin = re + " + " + im + "i";
		return complexezin;
	}
}