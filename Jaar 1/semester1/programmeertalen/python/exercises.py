#! /usr/bin/env python3

# Student: 		Sander Hansen
# Student-ID: 	10995080
# Programma:	exercises.py
# Beschrijving:	Oefen opgaves voor Python

import math

# Opdracht 1
def lees_sudoku(bestand):
	"""Functie leest bestand in en print deze """
	with open( bestand ) as f:
		regels = f.readlines()

		# List comp via http://goo.gl/f9Mn44 om te splitten op spaties in integers
		for x in range(0, len(regels)):
			regels[x] = [int(i) for i in regels[x].split()]

		for x in range(0, len(regels)):
			for y in range(0, len(regels[x])):
				print(regels[x][y], end=" ")
			print()

# Opdracht 2
def integer_test(lijst):
	"""Functie die test of lijst met n integers alle integers van 1 tot n bevat."""

	lengte = len(lijst)

	for getal in range(1, lengte + 1):
		if getal not in lijst:
			return False
	else:
		return True

# Opdracht 3
def integer_generator(lijst):
	"""Generator Functie die van lijst met lengte n, alle getallen tot n returned
	die niet in de lijst voorkomen."""

	lengte = len(lijst)

	for getal in range(1, lengte):
		if getal not in lijst:
			yield(getal)


# Opdracht 4a
def sudoku_verbouwer(sudoku):
	"""Zet de rijen van een sudoku om zodat de vierkanten als rijen worden
	gerepresentateerd. Op deze manier kan er makkelijk mee worden gerekend"""

	lengte = len(sudoku)
	vierkantCheckLijst = []

	# Maak een lege lijst aan met de juiste grootte
	for i in range(0, lengte):
		vierkantCheckLijst.append([])

	# Voor elke rij met daarin voor elke kolom de onderdelen op de juiste
	# index op de juiste plaats plaatsen. (Index in vierkant wordt berekent
	# in aparte fucntie)
	for rijIndex in range(0, lengte):
		rij = sudoku[rijIndex]

		for kolomIndex in range(0, lengte):
			vierkantIndex = vierkant_index_berekening(rijIndex, kolomIndex, lengte)
			vierkantCheckLijst[vierkantIndex].append(rij[kolomIndex])

	return vierkantCheckLijst

# Opdracht 4b
def vierkant_index_berekening(rijIndex, kolomIndex, lengte):
	"""Functie returned de index waarde als een sudoku omgezet is naar rijIndex
	die vierkanten voorstellen"""

	wortel = math.sqrt(lengte)

	#Vanwege afronding elk onderdeel omzetten naar int, en vermenigvuldigen met wortel
	vierkantIndex = int(rijIndex / wortel) * wortel + int(kolomIndex / wortel)
	return int(vierkantIndex)



