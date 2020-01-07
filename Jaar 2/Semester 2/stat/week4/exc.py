from pylab import *

def get_detail(a, x, y, k, e_vector, mean):
    detail = a[x:x + 25,y:y + 25]

    # Calc coordinates
    detail_1D = (a[x:x + 25, y: y + 25].reshape((625, 1)) - mean)

    coord_1D = np.dot(np.transpose(e_vector), detail_1D)

    # Make picture
    eigen_detail = (np.dot(e_vector[:, :k], coord_1D[:k]) +
                    mean).reshape((25, 25))

    return detail, eigen_detail


if __name__ == '__main__':
    a = imread('data/trui.png')
    d = a[100:126,100:126]


    vector = np.zeros((625, 1))
    matrix = np.zeros((625, 625))

    # Vector sum and matrix
    for i in range(232):
        for j in range(232):
            xi = a[i:i+25, j:j+25].reshape((625, 1))
            vector += xi
            matrix += xi * np.transpose(xi)
        print(i)

    # Calculate mean and covariance matrix
    m = vector / (232.0 * 232.0)
    S =  ((matrix - ((232.0 * 232.0) * m * np.transpose(m))) /
         (232.0 * 232.0 - 1))

    # Calculate eigen values
    eigenvalues, eigenvectors = np.linalg.eig(S)
    index = np.argsort(eigenvalues)[::-1]
    sorted_eigenvalues = eigenvalues[index]
    sorted_eigenvectors = eigenvectors[:, index]

    plt.subplot(3,6,1)
    xvals = np.arange(sorted_eigenvalues.shape[0])
    plt.plot(xvals, sorted_eigenvalues, "ro-", linewidth=1)
    plt.title("Scree Plot")
    plt.ylabel("Eigenvalue")
    plt.yscale("log")
    plt.xlabel("Number of value")

    # Plot eigen vectors (6 biggest ones)
    for i in range(6):
        plt.subplot(3,6,i+7)
        plt.title("Image from eigenvector")
        image = sorted_eigenvectors[i].reshape((25,25))
        imshow(image)

    detail, eigen_detail = get_detail(a, 0, 0, 20, sorted_eigenvectors, m)

    plt.subplot(3,6,13)
    imshow(detail)
    plt.subplot(3,6,14)
    imshow(eigen_detail)

    print("A k around 20 would be good enough for a nice picture")

    plt.show()
