"""
Lab 4 - Transform
NAME: Sander Hansen
STUDENT ID: 10995080
DESCRIPTION: This program can transform a given graph to a graph with numbers
as name indicators.
"""
import networkx as nx
import pydot
from networkx.drawing.nx_pydot import write_dot
from subprocess import check_call

G = nx.read_gml("aarnet.gml")
dictionary = {}
i = 0

# Sorteer de nodes
nodes = G.nodes()
nodes.sort()

for node in nodes:
    dictionary[node] = i
    i += 1

I = nx.relabel_nodes(G, dictionary)

write_dot(I, "Sander_Hansen-Transform.dot")
# Used http://bit.ly/2cVpREp for converting dot
check_call(['dot', '-Tpng', 'Sander_Hansen-Transform.dot', '-o',
            'Sander_Hansen-Transform.png'])
