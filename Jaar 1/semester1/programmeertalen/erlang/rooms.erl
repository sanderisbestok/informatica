% Student: 		Sander Hansen
% Student-ID: 	10995080
% Programma:	rooms.erl
% Beschrijving:

-module(rooms).
-export([add_wall/4, start/0]).

% Gives back coordinations of points where a wall is between.
get_wall(X, Y, north) 	-> {{X, Y - 1},{X, Y}};
get_wall(X, Y, east) 	-> {{X, Y},{X + 1, Y}};
get_wall(X, Y, south) 	-> {{X, Y},{X, Y + 1}};
get_wall(X, Y, west) 	-> {{X - 1, Y},{X, Y}}.

% Gives back a grid with the width, height and a empty list
new_grid(Width, Height) -> {Width, Height, []}.

% Gives back a grid with the excisting walls.
add_wall(X, Y, Dir, Grid) -> {element(1, Grid), element(2, Grid),
	lists:append([get_wall(X,Y, Dir)], element(3, Grid))}.

% Gives back a boolean if a wall is present in a grid
has_wall(X, Y, Dir, Grid) -> lists:member(get_wall(X, Y, Dir), element(3, Grid)).

% Function that will print the grid with help of other functions
print_grid(Grid) ->
	io:fwrite("~nGame board:~n~n"),

	print_grid(0, Grid).

% Prints grid with the help of recursion
print_grid(Row, Grid) ->
	case Row =< element(2, Grid) of
		true ->
			print_hlines(Row, 0, Grid),
			print_vlines(Row, 0, Grid),
			print_grid(Row + 1, Grid);
		false ->
			io:fwrite("")
	end.

% Prints horizontol lines
print_hlines(Row, Col, Grid) ->
	case Col =< element(1, Grid) of
		true ->
			io:fwrite("+"),
			case has_wall(Col, Row, north, Grid) of
				true ->
					io:fwrite("--");
				false ->
					io:fwrite("  ")
			end,
			print_hlines(Row, Col + 1, Grid);
		false ->
			io:fwrite("~n")
	end.

% Prints vertical lines
print_vlines(Row, Col, Grid) ->
	case Col =< element(1, Grid) of
		true ->
			case has_wall(Col, Row, west, Grid) of
				true ->
					io:fwrite("|  ");
				false ->
					io:fwrite("   ")
			end,
			print_vlines(Row, Col + 1, Grid);
		false ->
			io:fwrite("~n")
	end.

% Gets all the walls of a given cell
get_cell_walls(X, Y) ->
	[get_wall(X, Y, Dir) || Dir <- [north, east, west, south]].

% Get all the walls of the cell's with a certain width and height
get_all_walls(W, H) ->
	Cells = [get_cell_walls(X, Y) || X <- lists:seq(0, W - 1), Y <- lists:seq(0, H - 1)],
	lists:usort(lists:merge(Cells)).

% Get all the spots that are free for building a wall in a certain grid
get_open_spots(Grid) ->
	{X, Y, Walls} = Grid,
	get_all_walls(X, Y) -- Walls.

% Choose a random open wall wall of a certain grid
choose_random_wall(Grid) ->
	Open_spots = get_open_spots(Grid),
	lists:nth(random:uniform(length(Open_spots)), Open_spots).

% Build a random wall on a open spot in a certain grid.
build_random_wall(Grid) ->
	{X, Y, Walls} = Grid,
	{X, Y, [choose_random_wall(Grid)|Walls]}.

% Function that will return all walls where can be build of a certain cell
get_open_cell_walls(X, Y, Grid) ->
	{_, _, Walls} = Grid,
	get_cell_walls(X, Y) -- Walls.

% Get all the walls that will complete a room
get_completable_walls(Grid) ->
	{W, H, _} = Grid,
	Open_walls = [get_open_cell_walls(X, Y, Grid) || {X, Y} <-
	[{X, Y} || X <- lists:seq(0, W - 1), Y <- lists:seq(0, H - 1)]],

	% Selecting only the cells that can be completed, merge the walls that will complete those cells.
	lists:merge([Completable_walls || Completable_walls <- Open_walls, length(Completable_walls) == 1]).

% Get a single wall that will complete a room
get_completable_wall(Grid) ->
	lists:nth(1, get_completable_walls(Grid)).

% Function that will build a random wall or if possible a wall that completes a room.
build_wall(Grid) ->
	{X, Y, Walls} = Grid,
	case length(get_completable_walls(Grid)) == 1 of
		true ->
			{X, Y, [get_completable_wall(Grid)|Walls]};
		false ->
			build_random_wall(Grid)
	end.

% starts the program with X players
start() ->
	random_seed(),
	% Only numbers can be entered, solution from; http://goo.gl/qRiK1m
	Players = list_to_integer(re:replace(io:get_line("How many players? "), "[^0-9]", "", [global, {return, list}])),
	Processes = [ spawn(fun() -> player(X) end) || X <- lists:seq(1, Players) ],
	hd(Processes) ! {new_grid(6,6), rotate(Processes)}.

% Player will only continue if the player before finished their turn.
player(X) ->
	random_seed(),
	receive
		{Grid, Processes} ->
			case length(get_open_spots(Grid)) == 0 of
				true ->
					lists:foreach(fun(P) -> P ! stop end, Processes),
					player(X);
				false ->
					Grid2 = build_wall(Grid),
					print_grid(Grid2),
					hd(Processes) ! {Grid2, rotate(Processes)},
					player(X)
			end;
		stop ->
			io:fwrite("Player Finished~n");
		_ ->
			io:fwrite("Error")
	end.

% Rotate function from slides
rotate([H|T]) ->
	T ++ [H].

random_seed() ->
	<<S1:32, S2:32, S3:32>> = crypto:rand_bytes(12),
	random:seed({S1, S2, S3}).
%io:format(os:cmd("clear")).