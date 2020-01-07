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

%Base case van cost, als de route een lege lijst is is de cost 0.
cost([], 0).

%De cost hangt af van het laatste onderdeel uit een edge, mbv recursie tellen we
%de cost op tot de lijst leeg is.
cost(Path, Cost) :-
	Path = [edge(_, _, Cost1)|T],
	cost(T, Cost2),

	Cost is Cost1+Cost2.

%Berekend het kortste pad door de onderdelen van Pathlist te sorteren
shortestPath(From, To, Path) :-
	findall(P, path(From, To, P), Pathlist),
	quicksort(<,Pathlist, SortedList),
	SortedList = [Path|_].


%Quicksort gebruikt om te sorteren op edges, via: https://goo.gl/sMUQw0
%(Inspiratiebron KI-Studenten), Deze sorteerd de lijst op het achtersteonderdeel
quicksort(_, [], []).

quicksort(Rel, [Head|Tail], SortedList) :-
	split(Rel, Head, Tail, Left, Right),
	quicksort(Rel, Left, SortedLeft),
	quicksort(Rel, Right, SortedRight),
	append(SortedLeft, [Head|SortedRight], SortedList).

split(_, _, [], [], []).

split(Rel, Middle, [Head|Tail], [Head|Left], Right) :-
	check(Rel, Head, Middle), !,
	split(Rel, Middle, Tail, Left, Right).
split(Rel, Middle, [Head|Tail], Left, [Head|Right]) :-
	split(Rel, Middle, Tail, Left, Right).

check(Rel, A, B) :-
	cost(A, CostA),
	cost(B, CostB),
	Goal =.. [Rel,CostA,CostB], % so Goal becomes Rel(A,B)
	call(Goal).

