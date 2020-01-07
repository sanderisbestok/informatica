"""
Lab 4 - Transform
NAME: Sander Hansen
STUDENT ID: 10995080
DESCRIPTION: This program will calculate all the shortest paths. (Between
all the nodes). It wil also calculate the diameter and check how many routes
are bigger then a route between two given points. Which can be given at rul
26/27.
"""
import networkx as nx
import matplotlib.pyplot as plt
import heapq
import itertools
from geopy.distance import vincenty


def main():
    distance = {}
    previous = {}
    temp_previous = {}
    maximum_list = []
    G = nx.read_gml("aarnet.gml")
    G = get_distance(G)

    # You have to set those variables for checking how many shortest paths are
    # bigger then the chosen route
    check_value_from = "Adelaide1"
    check_value_to = "Cairns"
    check_value, _ = shortest_path(G, check_value_from, check_value_to)
    check_value_counter = 0

    nodes = G.nodes()

    pairs = list(itertools.combinations(nodes, 2))

    # iter over all the pairs and calculate all the shortest paths
    for pair in pairs:
        temp_distance, previous[pair[0]] = shortest_path(G, pair[0], pair[1])

        # max function does not work with empty dict items, so filter them out
        for item in temp_distance.items():
            if not item[1]:
                temp_distance.pop(item[0], None)
            if item[1] > check_value[check_value_to]:
                check_value_counter += 1
        # get the max value per pair (also save all the info)
        max_value = max(temp_distance, key=temp_distance.get)
        maximum_list.append((pair[0], max_value, temp_distance[max_value]))
        distance[pair[0]] = temp_distance

    # get the diameter
    longest_tuple = max(maximum_list, key=lambda x: x[2])

    print "Diameter: " + str(longest_tuple[2])
    print "From " + str(longest_tuple[0]) + " to " + str(longest_tuple[1])

    temp_previous = previous[longest_tuple[0]]
    diameter_nodes = get_route(G, longest_tuple[1], temp_previous)

    print "Nodes: " + str(diameter_nodes)
    print ("\n\nThe amount of routes that are bigger than: " +
           str(check_value[check_value_to]) + "  which is the route between " +
           check_value_from + " and " + check_value_to + " is: " +
           str(check_value_counter))


# Using dijkstra as described on http://bit.ly/1MURZs9 (wikipedia)
def shortest_path(G, source, target):
    distance = {}
    previous = {}
    priority = []

    for node in G.nodes():
        distance[node] = ""
        previous[node] = ""

    heapq.heappush(priority, (0, source))
    distance[source] = 0

    while priority:
        cost, u = heapq.heappop(priority)

        for neighbor in G.neighbors(u):
            alt = cost + G.edge[u][neighbor]["Distance"]
            if alt < distance[neighbor]:
                distance[neighbor] = alt
                previous[neighbor] = u

                if target == u:
                    return distance, previous

                heapq.heappush(priority, (alt, neighbor))

    return distance, previous


def get_route(G, target, previous):
    route = []
    u = target

    while previous[u]:
        route = [u] + route
        u = previous[u]

    route = [u] + route

    return route


def get_distance(G):
    lat = []
    lon = []

    for edge in G.edges():
        for node in G.nodes(data=True):
            if node[0] == edge[0] or node[0] == edge[1]:
                lat.append(node[1]["Latitude"])
                lon.append(node[1]["Longitude"])

        distance = int(vincenty((lat[0], lon[0]), (lat[1], lon[1])).meters)

        G.edge[edge[0]][edge[1]]["Distance"] = distance
        G.edge[edge[0]][edge[1]]["Color"] = "k"

        del lat[:]
        del lon[:]

    return G

if __name__ == "__main__":
    main()
