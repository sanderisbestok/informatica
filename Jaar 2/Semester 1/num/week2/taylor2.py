import numpy as np

def taylor(n):
    result = 0

    for k in range(2*n-1):
        result += (((-1)**k)/(2*k+1))

    return ((result * 4) + 1/(2*n))

if __name__ == "__main__":
    result = 0.0

    print("N \t Number")
    for n in range(1, 101):
        print("%d\t%.20f"%(n,taylor(n)))
