%Edges overgenomen vanuit de opdracht
edge(1, 2, 5).
edge(2, 1, 3).
edge(2, 3, 4).
edge(2, 4, 3).
edge(2, 5, 5).
edge(3, 1, 9).
edge(3, 2, 2).
edge(5, 1, 3).
edge(5, 4, 2).

%Base Case voor het path
path(From, To, Path) :-
	%Travel Predikaat, deze wordt gecheckt of deze waar is
	travel(From, To, [], Q),
	%Reverse checkt of Q gelijk is aan Path.
	reverse(Q, Path).

%Eerste travel predikaat, checkt of er een directe verbinding is tussen de edge
%Als dit waar is dan is travel waar.
travel(From, To, Fromlist, [edge(From, To, Cost)|Fromlist]) :-
	edge(From, To, Cost).

%Tweede travel predikaat, als er geen directe verbinding is tussen de edge,
travel(From, To, Visited, Path) :-
	edge(From, C, Cost),
	%Zorg dat C niet gelijk is aan de plek waar je heen moet
	C \== To,
	%Kijkt of de edge al in de Visited lijst staat
	\+ member(edge(_, C, _), Visited),
	\+ member(edge(C, _, _), Visited),
	travel(C, To, [edge(From, C, Cost)|Visited], Path).
