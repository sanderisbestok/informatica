def main():
    dataset1 = [np.random.normal(0,1) for i in range(0, 10**2)]
    dataset2 = [np.random.logistic(0,1) for i in range(0, 10**2)]

    (d,prob,ne) = kstest(dataset1,dataset2)
    print("D =",d)
    print("Prob =",prob)
    print("Ne =",ne)
    return 0

def kstest(datalist1, datalist2):
    n1 = len(datalist1)
    n2 = len(datalist2)
    datalist1.sort()
    datalist2.sort()

    j1 = 0
    j2 = 0
    d = 0.0
    fn1=0.0
    fn2=0.0
    
    while j1<n1 and j2<n2:
        d1 = datalist1[j1]
        d2 = datalist2[j2]
        if d1 <= d2:
            fn1 = (float(j1)+1.0)/float(n1)
            j1+=1
        if d2 <= d1:
            fn2 = (float(j2)+1.0)/float(n2)
            j2+=1
        dtemp = math.fabs(fn2-fn1)
        if dtemp>d:
            d=dtemp

    ne = float(n1*n2)/float(n1+n2)
    nesq = math.sqrt(ne)
    prob = ksprob((nesq+0.12+0.11/nesq)*d)
    return d,prob,ne

def ksprob(alam):
    fac = 2.0
    sum = 0.0
    termbf = 0.0

    a2 = -2.0*alam*alam
    for j in range(1,101):
        term = fac*math.exp(a2*j*j)
        sum += term
        if math.fabs(term) <= 0.001*termbf or math.fabs(term) <= 1.0e-8*sum:
            return sum
        fac = -fac
        termbf = math.fabs(term)

    return 1.0


if __name__ == "__main__":
    import sys
    import numpy as np
    import math
    sys.exit(main())
