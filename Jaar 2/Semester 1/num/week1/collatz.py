def collatz(number, list):
    list.append(number)

    if (number == 1):
        return
    elif (number % 2 == 0):
        collatz((int(number / 2)), list)
    else:
        collatz(((number * 3) + 1), list)

def multiple(n, biglist):
    for i in range(n):
        list = []

        collatz((n - i), list)

        biglist.append((list, len(list)))

    return biglist

def smallest(length, list):
    i = 0
    while (len(list) != length):
        del list[:]
        i += 1

        collatz(i, list)


if __name__ == "__main__":
    list = []
    number= 27

    collatz(number, list)

    print("Lengte van de lijst is: %d" %len(list))
    print("->".join(str(x) for x in list))

    biglist = []
    n = 29

    multiple(n, biglist)

    print("\n\nFrom %d to 1 we have the following lists (list, length)" %n)
    for x in biglist:
         print(x)

    biglist = []
    n = 99999
    multiple(n, biglist)

    result = max(biglist,key=lambda item:item[1])

    print("\n\nThe longest list with a starting number less than %d has a length of %d and starts with %d" %(n + 1, result[1], result[0][0]))

    list = []
    n = 500
    smallest(n, list)

    print("\n\nThe list with the lowest starting point and length %d is:" %n)
    print(list)
