#!/usr/bin/python3
import fileinput
import sys

array = []

for line in fileinput.input():
    try:
        array.append(list(map(int, line.split())))
    except EOFError:
        break

height = len(array)

for x in range(1, (height)):
    width = len(array[height - 1 - x])

    for y in range(0, width):
        max_value = max(array[(height - x)][y], array[(height - x)][y + 1])

        array[height - 1 - x][y] += max_value

print(array[0][0])
