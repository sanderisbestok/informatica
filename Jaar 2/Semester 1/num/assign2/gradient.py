import matplotlib.pyplot as plt
import numpy as np
from scipy import ndimage

import filters


def convolve_image(img, filter_kernel):
    """Convolves any given image with any given filter"""
    return ndimage.convolve(img, filter_kernel, cval=0.0)


def show_images(images, cm=plt.cm.gray, axis='off', quiver=False):
    """Shows an array of images in a figure-sublot

    Args:
        img(list) - list of images

    Optional:
        cm(plt.cm) - maptlotlib colormap
        axis(str) - argument to give plt
    """
    number_images = len(images)
    x, y = np.shape(images[0])
    stepsize = 2

    fig = plt.figure()
    for i, img in enumerate(images):
        fig.add_subplot(1, number_images, i + 1)
        plt.axis(axis)
        plt.imshow(img, cmap=cm)

        # If it's the first image and we want the quiver apply it
        if i == 0 and quiver:
            gridx, gridy = np.meshgrid(np.arange(0, x, stepsize),
                                       np.arange(0, y, stepsize))

            plt.quiver(gridx, gridy, images[1][::stepsize, ::stepsize],
                       images[2][::stepsize, ::stepsize], color="g")
    plt.show()


def prewitt_assignment(img):
    """
    This function applies the gradient filters to the image and shows them.
    """
    # Get filter:
    filter_x, filter_y = filters.prewitt()
    x, y = np.shape(img)

    # Apply Filter
    gradient_x = convolve_image(img, filter_x)
    gradient_y = convolve_image(img, filter_y)

    # Show result
    show_images([img, gradient_x, gradient_y], quiver=True)


def laplace_assignment(img):
    """
    This function calculates the Laplace by a convolve with the matrix you can
    derive from the laplace operator.
    """
    # Apply filter
    laplace = convolve_image(img, filters.laplace())

    # Show result
    show_images([img, laplace])


def gauss_assignment(img):
    """
    This function convolves Gaussian filter with the image and subtracts the
    filtered image from it.
    """
    # Apply filter
    gaussian = ndimage.filters.gaussian_filter(img, 5)

    # Substract orinal from filtered image
    substract = np.subtract(gaussian, img)

    # Show result
    show_images([img, gaussian, substract])


def sobel_assignment(img):
    """
    This function convolves the image with the derivative of x- and y-. We can
    approach the length of gradient with the help of these deriatives.
    """
    # Get filter
    sobel_x, sobel_y = filters.sobel()

    # Apply filter
    ISx = convolve_image(img, sobel_x)
    ISy = convolve_image(img, sobel_y)

    # Approach length of gradient
    G = np.sqrt(ISx**2 + ISy**2)

    # Show result
    show_images([ISx, ISy, G])


if __name__ == "__main__":
    img = ndimage.imread('img/lena.png', flatten=True)

    prewitt_assignment(img)
    # gauss_assignment(img)
    # laplace_assignment(img)
    # sobel_assignment(img)
