with open('ciphertexts.txt') as textFile:
    ciphertexts = [line.split() for line in textFile]
    for line in ciphertexts:
        line[0] = [line[0][i:i+2] for i in range(0, len(line[0]), 2)]

c0 = ciphertexts[0][0]
c1 = ciphertexts[1][0]
c2 = ciphertexts[2][0]
c3 = ciphertexts[3][0]
c4 = ciphertexts[4][0]
c5 = ciphertexts[5][0]
c6 = ciphertexts[6][0]
c7 = ciphertexts[7][0]

for i in range(len(c0)):
    c0c1 =  '{0:08b}'.format((int(c0[i], 16)^int(c1[i],16)))
    c0c2 =  '{0:08b}'.format((int(c0[i], 16)^int(c2[i],16)))
    c0c3 =  '{0:08b}'.format((int(c0[i], 16)^int(c3[i],16)))
    c0c4 =  '{0:08b}'.format((int(c0[i], 16)^int(c4[i],16)))
    c0c5 =  '{0:08b}'.format((int(c0[i], 16)^int(c5[i],16)))
    c0c6 =  '{0:08b}'.format((int(c0[i], 16)^int(c6[i],16)))
    c1c2 =  '{0:08b}'.format((int(c1[i], 16)^int(c2[i],16)))
    c1c3 =  '{0:08b}'.format((int(c1[i], 16)^int(c3[i],16)))
    c1c4 =  '{0:08b}'.format((int(c1[i], 16)^int(c4[i],16)))
    c1c5 =  '{0:08b}'.format((int(c1[i], 16)^int(c5[i],16)))
    c1c6 =  '{0:08b}'.format((int(c1[i], 16)^int(c6[i],16)))
    c2c3 =  '{0:08b}'.format((int(c2[i], 16)^int(c3[i],16)))
    c2c4 =  '{0:08b}'.format((int(c2[i], 16)^int(c4[i],16)))
    c2c5 =  '{0:08b}'.format((int(c2[i], 16)^int(c5[i],16)))
    c2c6 =  '{0:08b}'.format((int(c2[i], 16)^int(c6[i],16)))
    c3c4 =  '{0:08b}'.format((int(c3[i], 16)^int(c5[i],16)))
    c3c5 =  '{0:08b}'.format((int(c3[i], 16)^int(c5[i],16)))
    c3c6 =  '{0:08b}'.format((int(c3[i], 16)^int(c6[i],16)))
    c4c5 =  '{0:08b}'.format((int(c4[i], 16)^int(c5[i],16)))
    c4c6 =  '{0:08b}'.format((int(c4[i], 16)^int(c6[i],16)))
    c5c6 =  '{0:08b}'.format((int(c5[i], 16)^int(c6[i],16)))
