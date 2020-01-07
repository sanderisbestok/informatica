import numpy as np
import numpy.linalg as la

if __name__ == "__main__":

    A = np.array([[5,-2, 2],[-2,5,1],[2,1,2]])
    L = la.cholesky(A)
    L_trans = np.transpose(L)
    QR = la.qr(A)

    print("A = ")
    print(A)

    print("\nCholesky:")
    print("L = ")
    print(L)
    print("L^(t) = ")
    print(L_trans)
    print("LL^(t) = ")
    print(L.dot(L_trans))

    print("\nQR decomposition:")
    print("Q = ")
    print(QR[0])
    print("R = ")
    print(QR[1])
    print("QR = ")
    print(QR[0].dot(QR[1]))
