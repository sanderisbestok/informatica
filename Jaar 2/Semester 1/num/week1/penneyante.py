import random

def spel(machine, endA, endB):
    current = 0

    while (current != endA and current != endB):
        coin = random.randint(0, 1)

        current = machine[(current, coin)]

    return current

def kans():
    machine = {
    (0, 0) : 1,
    (0, 1) : 4,
    (1, 0) : 2,
    (1, 1) : 4,
    (2, 0) : 2,
    (2, 1) : 3,
    (4, 0) : 5,
    (4, 1) : 4,
    (5, 0) : 6,
    (5, 1) : 4,
    }

    count = 10000
    bob = 0

    for i in range(count):
        if (spel(machine, 3, 6) == 6):
            bob += 1

    return ((float(bob) / count) * 100)

def spel_patroon(a, b):
    coins = [2, 2, 2]

    while ( a != coins and b != coins):
        coin = random.randint(0, 1)

        coins[0] = coins[1]
        coins[1] = coins[2]
        coins[2] = coin

    if (coins == a):
        return 1
    else:
        return 0


def patroon(a, b):
    a_win = 0
    count = 10000

    for i in range(count):
        if(spel_patroon(a, b)):
            a_win += 1

    return (round(((float(a_win) / count) * 100), 2))


if __name__ == "__main__":
    machine = {
    (0, 0) : 1,
    (0, 1) : 0,
    (1, 0) : 2,
    (1, 1) : 3,
    (2, 0) : 2,
    (2, 1) : 4,
    (3, 0) : 1,
    (3, 1) : 5,
    }

    if (spel(machine, 4, 5) == 4):
        print("Anna wint")
    else:
        print("Bob wint")

    print("Bob wint", round(kans(), 2), "% van de spellen")

    print("A: KKK, B: KKM, A wins",patroon([0,0,0],[0, 0, 1]),"%")
    print("A: KKK, B: KMK, A wins",patroon([0,0,0],[0, 1, 0]),"%")
    print("A: KKK, B: KMM, A wins",patroon([0,0,0],[0, 1, 1]),"%")
    print("A: KKK, B: MKK, A wins",patroon([0,0,0],[1, 0, 0]),"%")
    print("A: KKK, B: MKM, A wins",patroon([0,0,0],[1, 0, 1]),"%")
    print("A: KKK, B: MMK, A wins",patroon([0,0,0],[1, 1, 0]),"%")
    print("A: KKK, B: MMM, A wins",patroon([0,0,0],[1, 1, 1]),"%")

    print("A: KKM, B: KMK, A wins",patroon([0,0,1],[0, 1, 0]),"%")
    print("A: KKM, B: KMM, A wins",patroon([0,0,1],[0, 1, 1]),"%")
    print("A: KKM, B: MKK, A wins",patroon([0,0,1],[1, 0, 0]),"%")
    print("A: KKM, B: MKM, A wins",patroon([0,0,1],[1, 0, 1]),"%")
    print("A: KKM, B: MMK, A wins",patroon([0,0,1],[1, 1, 0]),"%")
    print("A: KKM, B: MMM, A wins",patroon([0,0,1],[1, 1, 1]),"%")

    print("A: KMK, B: KMM, A wins",patroon([0,1,0],[0, 1, 1]),"%")
    print("A: KMK, B: MKK, A wins",patroon([0,1,0],[1, 0, 0]),"%")
    print("A: KMK, B: MKM, A wins",patroon([0,1,0],[1, 0, 1]),"%")
    print("A: KMK, B: MMK, A wins",patroon([0,1,0],[1, 1, 0]),"%")
    print("A: KMK, B: MMM, A wins",patroon([0,1,0],[1, 1, 1]),"%")

    print("A: KMM, B: MKK, A wins",patroon([0,1,1],[1, 0, 0]),"%")
    print("A: KMM, B: MKM, A wins",patroon([0,1,1],[1, 0, 1]),"%")
    print("A: KMM, B: MMK, A wins",patroon([0,1,1],[1, 1, 0]),"%")
    print("A: KMM, B: MMM, A wins",patroon([0,1,1],[1, 1, 1]),"%")

    print("A: MKK, B: MKM, A wins",patroon([1,0,0],[1, 0, 1]),"%")
    print("A: MKK, B: MMK, A wins",patroon([1,0,0],[1, 1, 0]),"%")
    print("A: MKK, B: MMM, A wins",patroon([1,0,0],[1, 1, 1]),"%")

    print("A: MKM, B: MMK, A wins",patroon([1,0,1],[1, 1, 0]),"%")
    print("A: MKM, B: MMM, A wins",patroon([1,0,1],[1, 1, 1]),"%")

    print("A: MMK, B: MMM, A wins",patroon([1,1,0],[1, 1, 1]),"%")
