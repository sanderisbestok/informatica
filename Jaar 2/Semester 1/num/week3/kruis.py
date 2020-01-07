import numpy as np
import matplotlib.pyplot as plt

def x(n):
    if n < 0:
        return 0
    else:
        return n**2

def w(n):
    if np.absolute(n) == 1:
        return n / 2
    else:
        return 0


if __name__ == "__main__":
    lijst = []
    lijst.append(x(1))
    lijst.append(x(2))
    lijst.append(x(3))
    lijst.append(x(4))
    lijst.append(x(5))

    lijst2 = []
    lijst2.append(w(-1))
    lijst2.append(w(1))
    lijst2.append(w(-1))
    lijst2.append(w(1))
    lijst2.append(w(-1))

    print(np.correlate(lijst, lijst2, "same"))
