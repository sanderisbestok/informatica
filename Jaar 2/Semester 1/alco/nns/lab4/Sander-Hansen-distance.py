"""
Lab 4 - Distance
NAME: Sander Hansen
STUDENT ID: 10995080
DESCRIPTION: Will calculate the distance between two given points in a graph
(network). Points can be changed in rule 38/39.
"""
import networkx as nx
import matplotlib.pyplot as plt
import heapq
from geopy.distance import vincenty


def main():
    G = nx.read_gml("aarnet.gml")

    edges = G.edges()
    nodes = G.nodes(data=True)

    lat = []
    lon = []

    # Sla de Distance op
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

    distance, previous = shortest_path(G, "Adelaide1", "Brisbane1")
    route = get_route(G, "Brisbane1", previous)

    print "Distance: " + str(distance["Brisbane1"])
    print "Nodes: " + str(route)

    pos = nx.spring_layout(G)

    edges = G.edges()
    colors = [G[u][v]['Color'] for u, v in edges]
    nx.draw_networkx(G, pos, edges=edges, edge_color=colors)
    plt.savefig("Sander_Hansen-shortestpath.png")


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
        G.edge[route[0]][u]["Color"] = "r"

    route = [u] + route
    G.edge[route[0]][route[1]]["Color"] = "r"

    return route

if __name__ == "__main__":
    main()
