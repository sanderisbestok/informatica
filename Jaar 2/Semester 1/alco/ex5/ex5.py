import math

# Idea for algorithm from http://bit.ly/1oI2Ytk
def extended_gcd(a, b):
    if a == 0:
        return (b, 0, 1)
    else:
        g, x, y = extended_gcd(b % a, a)
        z = y - (b // a) * x
        return (g, z, x)

# Idea for algorithm from http://bit.ly/2dSlVpZ
def get_factor_fermat(n):
    a = math.ceil(math.sqrt(n))
    b2 = a * a - n

    while math.sqrt(b2) != math.floor(math.sqrt(b2)):
        a = a + 1
        b2 = a * a - n

    p = a - math.sqrt(b2)
    q = a + math.sqrt(b2)

    return int(p), int(q)

def main():
    amount = input().split()
    for i in range(int(amount[0])):
        n, e, c = list(input().split())
        n = int(n)
        e = int(e)
        c = int(c)

        p, q = get_factor_fermat(n)
        totient = ((p - 1) * (q - 1))
        _, gcd, _ = extended_gcd(e, totient)
        d = gcd % totient

        m = 1
        for i in range(1, (d + 1)):
            m = (m * c) % n
        print(m)


if __name__ == "__main__":
    main()
