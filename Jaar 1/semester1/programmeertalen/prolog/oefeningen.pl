%Voor de oplossing van append heb ik http://goo.gl/iep7Cl gebruikt
%Deze werkt als volgt; append plakt lijsten aan elkaar, de eerste regel zegt;
%Een lege lijst + lijst1 = lijst1 is waar. In de tweede regel zeggen we dat;
%Wanneer T(ail) + lijst2 = lijst3, dan is H(ead)|T(ail) + lijst2 = H(ead)|lijst3
%ook waar. Op deze manier telt append telkens een onderdeel van de lijst erbij op

append([],L1,L1).
append([H|T],L2,[H|L3]) :-
	append(T,L2,L3).

%Een palindroom is waar als het omgekeerde hetzelfde is. Dit wordt gecheckt
%met het omgekeerde predicaat. Hierbij wordt telkens de Head van de eerste
%term afgehaald en aan de laatste toegevoegd. In de basecase wordt gecheckt
%of de laatste twee lijsten gelijk zijn. Als dit waar is dan is het een palindroom.
omgekeerde([],Palindroom,Palindroom).

omgekeerde([Head | Tail],Resultaat,Optelling) :-
	omgekeerde(Tail,Resultaat,[Head | Optelling]).

palindroom(Palindroom) :- omgekeerde(Palindroom,Palindroom,[]).

%Deze is nodig om te kijken of alleen 1 t/m 4 voorkomt en voor all_different
:- use_module(library(clpfd)).

%Voor het algoritme heb ik inspiratie opgedaan bij http://goo.gl/F3OFEK
%Kijkt of in elke rij alles 1x voorkomt (all_different)
checken([]).
checken([Head|Tail]) :-
	all_different(Head),
	checken(Tail).


sudoku4(Sudoku,Solution) :-
%Import sudoku als 4 lijsten
	Sudoku = [
		[S1, S2, S3, S4],
		[S5, S6, S7, S8],
		[S9, S10, S11, S12],
		[S13, S14, S15, S16]
	],
	Solution = Sudoku,

	%Zet de lijsten om in losse variabelen
	Rij1 = [S1, S2, S3, S4],
	Rij2 = [S5, S6, S7, S8],
	Rij3 = [S9, S10, S11, S12],
	Rij4 = [S13, S14, S15, S16],

    %Kijkt of variableen 1 t/m 4 bevatten
    Rij1 ins 1..4,
    Rij2 ins 1..4,
    Rij3 ins 1..4,
    Rij4 ins 1..4,

	%Maakt kolommen
	Kol1 = [S1, S5, S9, S13],
	Kol2 = [S2, S6, S10, S14],
	Kol3 = [S3, S7, S11, S15],
	Kol4 = [S4, S8, S12, S16],

	%Maakt de vierkanten
	Vier1 = [S1, S2, S5, S6],
	Vier2 = [S3, S4, S7, S8],
	Vier3 = [S9, S10, S13, S14],
	Vier4 = [S11, S12, S15, S16],

	%Laat checken of de rijen kolommen en vierkanten unieke getallen bevatten
	checken([Rij1, Rij2, Rij3, Rij4, Kol1, Kol2, Kol3, Kol4, Vier1, Vier2, Vier3, Vier4]).

