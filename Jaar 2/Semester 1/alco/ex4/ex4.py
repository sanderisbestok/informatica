#!/usr/bin/python3
import fileinput
import sys


def main():
    graph = []

    students, thesis, amount = list(input().split())
    for i in range(int(amount)):
        graph.append(input().split())
        #graph[i][0] = int(graph[i][0])
        #graph[i][1] = int(graph[i][1])

    s = 0
    t = int(students) + int(thesis) + 1

    for edge in graph:
        edge[0] = int(edge[0])
        edge[1] = int(edge[1]) + int(students)
        edge.append(1)
        edge.append(0)

    for i in range(1, int(students) + 1):
        graph.append([int(s), int(i), 1, 0])

    for i in range(int(students) + 1, int(students) + int(thesis) + 1):
        graph.append([int(i), int(t), 1, 0])

    print(fordFulkers(graph, s, t))


def fordFulkers(graph, s, t):
    path = getPath(graph, s, t, [])
    if path != None:
        result = 1
    #print(path)
    residu = []

    while path != None:
        for edge in path:
            residu.append(edge[2] - edge[3])

        flow = min(residu)
        #print(flow)

        for edge in path:
            edge[3] += flow
            #print(edge)

        path = getPath(graph, s, t, [])

        if path != None:
            result += 1
        #print(path)

    #flow = 0

    #for edge in graph:
    #    flow += edge[3]

    return result

def getPath(graph, s, t, path):
    if int(s) == int(t):
        return path

    for edge in graph:

        if int(edge[0]) == int(s):
            residu = edge[2] - edge[3]

            if residu > 0 and not edge in path:
                result = getPath(graph, edge[1], t, path + [edge])

                if result != None:
                    return result

if __name__ == "__main__":
    main()
