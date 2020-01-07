import numpy as np

def taylor(n):
    result = 0

    for k in range(n):
        result += (((-1)**k)/(2*k+1))

    return result * 4

if __name__ == "__main__":
    result = 0.0
    n = 1
    max_iter = 1200

    print("Terms \t Number")
    while(round(taylor(n), 1) != (round(np.pi, 1)) and n < max_iter):
        n += 1
    if (n < max_iter):
        print("%d\t %.1f" %((n), round(taylor(n), 1)))
    while(round(taylor(n), 2) != (round(np.pi, 2))and n < max_iter):
        n += 1
    if (n < max_iter):
        print("%d\t %.2f" %((n), round(taylor(n), 2)))
    while(round(taylor(n), 3) != (round(np.pi, 3))and n < max_iter):
        n += 1
    if (n < max_iter):
        print("%d\t %.3f" %((n), round(taylor(n), 3)))
    while(round(taylor(n), 4) != (round(np.pi, 4))and n < max_iter):
        n += 1
    if (n < max_iter):
        print("%d\t %.4f" %((n), round(taylor(n), 4)))
    while(round(taylor(n), 5) != (round(np.pi, 5))and n < max_iter):
        n += 1
    if (n < max_iter):
        print("%d\t %.5f" %((n), round(taylor(n), 5)))
    else:
        print("Reached max iterations")

    
