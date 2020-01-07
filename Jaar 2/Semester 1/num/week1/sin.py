import math

# Door approxerror te veranderen naar 0.1 0.001 0.0001 of 0.0001 kan de
# absolute benaderingsfout bepaald worden.
if __name__ == "__main__":
    k = 1.0
    x = 0.5
    factor = -1
    approx = x
    term = 1
    approxerror = 0.00001

    while (math.fabs((approx - math.sin(x))) > approxerror):
        k += 2
        approx += factor * (math.pow(x,k))/math.factorial(k)
        term += 1
        factor = factor * -1

    print("Hoeveelheid termen is %d voor een precisie van %f" % (term, approxerror))

# Een vuistregel zou kunnen zijn voor elke 2n is een extra term nodig
