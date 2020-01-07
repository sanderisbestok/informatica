%Opdracht1
path(1, 3, Path).
path(3, 5, Path).
path(5, 4, Path).

%Opdracht2
path(5, 4, Path).

cost([edge(5, 4, 2)], Cost).
cost([edge(5, 1, 3), edge(1, 2, 5), edge(2, 4, 3)], Cost).

shortestPath(1, 3, Path).
shortestPath(3, 5, Path).
shortestPath(5, 4, Path).

%Opdracht3
shortestPath('Amsterdam Amstel' at Start, 'Sittard' at End, Path).

shortestPath('Amsterdam Centraal' at Start, 's-Hertogenbosch' at End, Path).

shortestPath('Eindhoven' at 13:02, 'Maastricht' at End, Path).
