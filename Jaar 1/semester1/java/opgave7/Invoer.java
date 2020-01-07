import java.util.*;
import java.lang.*;
public class Invoer {
	static Datum datum;

	public static void main(String[] args) {
		while (true) {
			try {
				datum = new Datum(krijgInvoer());
				break;
			} catch (InputMismatchException e1) {
				System.out.println("Foute invoer, probeer opnieuw.");
			} catch (IllegalArgumentException e2) {
				System.out.println(e2.getMessage());
			}
		}

		System.out.println(datum);
	}

	public static String krijgInvoer() {
		System.out.print("Geef een datum (dd-mm-jjjj) op: ");
		Scanner invoer = new Scanner(System.in);

		if (invoer.hasNextLine()) {
			return invoer.nextLine().trim();
		}

		return "";

	}
}