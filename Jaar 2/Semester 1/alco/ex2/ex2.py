#!/usr/bin/python3
import fileinput
import sys

array = []
information = []
nodes = []
final = 0
z = 0

for line in fileinput.input():
    try:
        if z == 0:
            information.append(list(map(int, line.split())))
            z = 1
        else:
            array.append(list(map(int, line.split())))

    except EOFError:
        break

array.sort(key=lambda x: x[2])

# Filling list of nodes
amountofnodes = information[0][0]
for x in range(0, amountofnodes):
    nodes.append([])
    for y in range(0,1):
        nodes[x].append(x)

for edge in array:
    m = 0
    q = 0
    w = 0
    same_node = False

    for node in nodes:
        if edge[0] in node and edge[1] in node:
            same_node = True
            break
        elif edge[0] in node:
            q = m
        elif edge[1] in node:
            w = m

        m += 1

    if not same_node:
        newnode = nodes[q] + nodes[w]

        if q > w:
            del nodes[q]
            del nodes[w]
        else:
            del nodes[w]
            del nodes[q]

        final += edge[2]
        nodes.append(newnode)

print(final)
