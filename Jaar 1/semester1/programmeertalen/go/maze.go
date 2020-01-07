// Student: 		Sander Hansen
// Student-ID: 		10995080
// Programma:		maze.go
// Beschrijving:	Programma dat mazes in het goeie formaat aangeleverd kan oplossen
package main

import (
	"bufio"
	"fmt"
	"os"
	"sync"
)

const southWall byte = 1
const eastWall byte = 2

type Maze [][]byte

type Position struct {
	Row, Col int
}

var channel chan []Position
var done chan int
var ack chan int
var maze Maze
var counter int

// Lees het doolhof in
func readMaze(f *os.File) (maze Maze) {
	s := bufio.NewScanner(f)
	for s.Scan() {
		maze = append(maze, []byte(s.Text()))
	}
	return
}

// Functie om het doolhof op te lossen
func solve(maze Maze) (route []Position) {
	var onceMaze [][]sync.Once

	// Initialiseer channels
	channel = make(chan []Position, 100000)

	done = make(chan int)
	ack = make(chan int, 10000)

	// onceMaze initialisatie verkregen van de werkgroep begeleider
	onceMaze = make([][]sync.Once, len(maze))

	for col, row := range(maze) {
	 	onceMaze[col] = make([]sync.Once, len(row))
	}

	// Legelijst initialiseren voor de eerste count
	var emptyList []Position
	counter++
	onceMaze[0][0].Do(func() {
		go findRoute(Position{0,0}, emptyList, maze)
	})

	// Zolang de counter nog geen 0 is (de routines nog niet voltooid zijn) door gaan met zoeken
	// tevens check of de oplossing gevonden is, dan route gelijk maken aan de locationhistory
	for counter != 0 {
		select {
			case element := <- channel:
				if route == nil {
					if element[len(element) - 1].Row == (len(maze) - 1) &&
					maze[element[len(element) - 1].Row][element[len(element) - 1].Col]&southWall == 0 {
						route = element
					} else if element[len(element) - 1].Col == (len(maze[0]) - 1) &&
					maze[element[len(element) - 1].Row][element[len(element) - 1].Col]&eastWall == 0 {
						route = element
					} else {
						onceMaze[element[len(element) - 1].Row][element[len(element) - 1].Col].Do(func() {
							counter++
							go findRoute(element[len(element) - 1], element, maze)
						})
					}
				}

				ack <- 1

			case <- done:
				counter--
		}
	}

	return route
}

// Functie om te kijken waar heen bewogen kan worden
func findRoute(currentPosition Position, positionHistory []Position, maze Maze) {
	if currentPosition.Row != 0 {
		// Check muur Noord
		if maze[currentPosition.Row - 1][currentPosition.Col]&southWall == 0 {
			var newHistory []Position
			newHistory = make([]Position, len(positionHistory))

			copy(newHistory, positionHistory)
			channel <- append(newHistory, Position{currentPosition.Row - 1, currentPosition.Col})
			<-ack
		}
	}

	if currentPosition.Col != 0 {
		//Check muur west
		if maze[currentPosition.Row][currentPosition.Col - 1]&eastWall == 0 {
			var newHistory []Position
			newHistory = make([]Position, len(positionHistory))

			copy(newHistory, positionHistory)
			channel <- append(newHistory, Position{currentPosition.Row, currentPosition.Col - 1})
			<-ack
		}
	}

	//Check muur zuid
	if maze[currentPosition.Row][currentPosition.Col]&southWall == 0 {
		var newHistory []Position
		newHistory = make([]Position, len(positionHistory))


		copy(newHistory, positionHistory)
		channel <- append(newHistory, Position{currentPosition.Row + 1, currentPosition.Col})
		<-ack
	}

	//Check muur Oost
	if maze[currentPosition.Row][currentPosition.Col]&eastWall == 0 {
		var newHistory []Position
		newHistory = make([]Position, len(positionHistory))

		copy(newHistory, positionHistory)
		channel <- append(newHistory, Position{currentPosition.Row, currentPosition.Col + 1})
		<-ack
	}

	done <- 1
}

func main() {
	f, _ := os.Open(os.Args[1])
	maze := readMaze(f)
	for _, pos := range solve(maze) {
		maze[pos.Row][pos.Col] |= 4
	}
	for _, line := range maze {
		fmt.Println(string(line))
	}
}

// BONUS
// Het pad is niet altijd het kortste pad omdat het op de volgorde is van de
// go routines. De goroutine die als eerste start en een lange route 'kiest'
// kan eerder klaar zijn dan de 72ste routine die een korte route 'kiest'.
// Hierdoor wordt deze als solution gegeven.

// Dit kan opgelost worden door de lengte van de solutions bij te houden en
// van de kortste lengte de route maken.