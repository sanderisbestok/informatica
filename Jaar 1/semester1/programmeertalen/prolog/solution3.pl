%Routes vanuit de opdracht
:- op(100, xfx, at).
:- op(50, xfx, :).
route([
'Amsterdam Centraal' at 11:08,
'Amsterdam Amstel' at 11:15,
'Utrecht Centraal' at 11:38,
's-Hertogenbosch' at 12:08,
'Eindhoven' at 12:32,
'Weert' at 12:49,
'Roermond' at 13:02,
'Sittard' at 13:21,
'Maastricht' at 13:35
]).

route([
'Amsterdam Centraal' at 11:38,
'Amsterdam Amstel' at 11:45,
'Utrecht Centraal' at 12:08,
's-Hertogenbosch' at 12:38,
'Eindhoven' at 13:02,
'Weert' at 13:19,
'Roermond' at 13:32,
'Sittard' at 13:51,
'Maastricht' at 14:05
]).

%Edge veranderd naar Travel dat deze werkt met de tijden
travel(From at From_Time, To at To_Time, Cost) :-
	route(List),
	nextto(From at From_Time, To at To_Time, List),
	diffTime(From_Time, To_Time, Cost), !.

%Base Case voor het path
path(From, To, Path) :-
	%Travel Predikaat, deze wordt gecheckt of deze waar is
	travel(From, To, [], Q),
	%Reverse checkt of Q gelijk is aan Path.
	reverse(Q, Path).

%Eerste travel predikaat, checkt of er een directe verbinding is tussen de locaties
%Als dit waar is dan is travel waar.
travel(From, To, Fromlist, [travel(From, To, Cost)|Fromlist]) :-
	travel(From, To, Cost).

%Tweede travel predikaat, als er geen directe verbinding is tussen de locaties,
travel(From, To, Visited, Path) :-
	travel(From, C, Cost),
	%Zorg dat C niet gelijk is aan de plek waar je heen moet
	C \== To,
	%Kijkt of de edge al in de Visited lijst staat
	\+ member(travel(_, C, _), Visited),
	\+ member(travel(C, _, _), Visited),
	travel(C, To, [travel(From, C, Cost)|Visited], Path).

%Base case van cost, als de route een lege lijst is is de cost 0.
cost([], 0).

%De cost hangt af van het laatste onderdeel uit een edge, mbv recursie tellen we
%de cost op tot de lijst leeg is.
cost(Path, Cost) :-
	Path = [travel(_, _, Cost1)|T],
	cost(T, Cost2),

	Cost is Cost1+Cost2.

%Berekend het kortste pad door de onderdelen van Pathlist te sorteren
shortestPath(From, To, Path) :-
	findall(P, path(From, To, P), Pathlist),
	quicksort(<,Pathlist, [Path|_]), !.


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

diffTime(H1:M1, H2:M2, Minutes) :-
	MinuteHours1 is H1*60,
	Time1 is M1+MinuteHours1,
	MinuteHours2 is H2*60,
	Time2 is M2+MinuteHours2,
	Minutes is Time2-Time1.
