import numpy as np
import numpy.linalg as la

if __name__ == "__main__":

    A = np.array([[-3 ,-1, 0],[4,7,-10],[4,3,-3]])
    B = np.array([[-2 ,2, -5],[12,-7,20],[6,-4,11]])
    C = np.array([[-2 ,14, 8],[-1,10,6],[1,-13,-8]])


    for i in range(2, 6):
        calc_a = la.matrix_power(A, i)
        calc_b = la.matrix_power(B, i)
        calc_c = la.matrix_power(C, i)

        print("Bij M = %d" %i)
        if (np.all(calc_a == A)):
            print("A is A")
        else:
            print("A is niet A")

        if (np.all(calc_b == B)):
            print("B is B")
        else:
            print("B is niet B")

        if (np.all(calc_c == 0)):
            print("C is C")
        else:
            print("C is niet C")
        print("\n")
