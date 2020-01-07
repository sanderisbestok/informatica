/*
 *	NAAM	: Sander Hansen
 *	CKNUM	: 10995080
 *	Studie	: Informatica
 *
 *	PolynoomInterface.java:
 *  - Dit is een aangeleverde interface voor Polynoom.java
 *	- Hierin staat hoe de wiskundige operatie methoden moeten worden beschreven.
 */
interface PolynoomInterface {
    Polynoom telop(Polynoom that);
    Polynoom trekaf(Polynoom that);
    Polynoom vermenigvuldig(Polynoom that);
    Polynoom differentieer();
    Polynoom integreer();
    boolean equals(Object o);
    String toString();
}
