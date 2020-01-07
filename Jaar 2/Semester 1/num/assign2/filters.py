import numpy as np


def prewitt():
    """returns x, and y Prewitt filter"""
    Px = np.array([[1, 0, -1],
                   [1, 0, -1],
                   [1, 0, -1]])
    Py = np.array([[1, 1, 1], [0, 0, 0], [-1, -1, -1]])

    return Px, Py


def laplace():
    """Laplace filter"""
    laplace = np.array([[0, 1, 0],
                       [1, -4, 1],
                       [0, 1, 0]])

    return laplace


def sobel():
    Sx = np.array([[1, 0, -1],
                   [2, 0, -2],
                   [1, 0, -1]])
    Sy = np.array([[1, 2, 1],
                   [0, 0, 0],
                   [-1, -2, -1]])

    return Sx, Sy
