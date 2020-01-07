package main

import (
	"fmt"
)

type Position struct {
	Row, Col int
}

func north(pos Position) Position {
	var x = pos.Row - 1
	var y = pos.Col

	var posNorth = Position{x, y}

	return posNorth
}

func main() {
	var pos1 = Position{54, 42}
	var pos2 = Position{53, 42}
	var pos3 = north(pos2)

	fmt.Println(pos1)
	fmt.Println(pos2)
	fmt.Println(pos3)
}