#! /usr/bin/env python3

# Student: 		Sander Hansen
# Student-ID: 	10995080
# Programma:	sudoku.py
# Beschrijving:	Kan een sudoku oplossen die in het juiste formaat aangeleverd wordt
#				Functie beschrijvingen staan tussen drie dubbele aanhalingstekens
#				en staan er niet in als commentaar.

import math

def lees_sudoku(bestand):
	"""Functie leest een bestand in """
	with open( bestand ) as f:
		rijen = f.readlines()

		# List comp via http://goo.gl/f9Mn44 om te splitten op spaties in integers
		for x in range(0, len(rijen)):
			rijen[x] = [int(i) for i in rijen[x].split()]

		return rijen

def kolommen_maker(rijen):
	"""Maakt kolommen van rijen zodat er met de kolommen gerekend kan worden"""
	kolommen = []

	# Voeg elke keer het eerste element uit een rij toe aan een nieuwe lijst
	# vervolgens tweede element, etc
	for x in range(len(rijen)):
		kolom = []

		for rij in rijen:
			kolom.append(rij[x])
		kolommen.append(kolom)

	return kolommen

def vierkanten_maker(rijen):
	"""Maakt vierkanten van rijen zodat er met de vierkanten gerekend kan worden"""
	lengte = len(rijen)
	vierkantCheckLijst = []

	# Maak een lege lijst aan met de juiste grootte
	for i in range(0, lengte):
		vierkantCheckLijst.append([])

	# Voor elke rij met daarin voor elke kolom de onderdelen op de juiste
	# index op de juiste plaats plaatsen. (Index in vierkant wordt berekent
	# in aparte functie)
	for rijIndex in range(0, lengte):
		rij = rijen[rijIndex]

		for kolomIndex in range(0, lengte):
			vierkantIndex = vierkant_index_berekening(rijIndex, kolomIndex, lengte)
			vierkantCheckLijst[vierkantIndex].append(rij[kolomIndex])

	return vierkantCheckLijst

def vierkant_index_berekening(rijIndex, kolomIndex, lengte):
	""""Berekent de index van het vierkant"""
	wortel = math.sqrt(lengte)

	#Vanwege afronding elk onderdeel omzetten naar int, en vermenigvuldigen met wortel
	vierkantIndex = int(rijIndex / wortel) * wortel + int(kolomIndex / wortel)

	return int(vierkantIndex)

def sudoku_oplosser(rijen, kolommen, vierkanten):
	"""Lost de sudoku op met behulp van de getal vinder functie"""
	sudokuOpgelost = []
	rijIndex = 0

	# Voor elke rij wordt er voor elk getal gecheckt of deze nul is,
	# als deze nul is wordt er gekeken wat er ingevuld kan worden (in andere functie)
	# en worden de rijen kolommen en vierkanten hier op aangepast.
	for rij in rijen:
		rijOpgelost = []
		kolomIndex = 0

		for getal in rij:
			if getal != 0:
				rijOpgelost.append(getal)
			else:
				gevondenGetal = getal_vinder(rijen[rijIndex], kolommen[kolomIndex],
				vierkanten[vierkant_index_berekening(rijIndex, kolomIndex, len(rijen))])

				rijOpgelost.append(gevondenGetal)

			kolomIndex = kolomIndex + 1

		rijen[rijIndex] = rijOpgelost
		kolommen = kolommen_maker(rijen)
		vierkanten = vierkanten_maker(rijen)

		sudokuOpgelost.append(rijOpgelost)
		rijIndex = rijIndex + 1

	return sudokuOpgelost

def getal_vinder(rij, kolom, vierkant):
	"""Kijkt welk getal er op de lege plek ingevuld kan worden"""
	rijGetallen = []
	kolomGetallen = []
	vierkantGetallen = []

	lengte = len(rijen) + 1

	# Checkt of de rijen, kolommen en vierkanten 1 tot en met 10 bevatten,
	# en maakt een lijst aan met mogelijkheden
	for getal in range(1, lengte):
		if getal not in rij:
			rijGetallen.append(getal)

	for getal in range(1, lengte):
		if getal not in kolom:
			kolomGetallen.append(getal)

	for getal in range(1, lengte):
		if getal not in vierkant:
			vierkantGetallen.append(getal)

	# Checkt of er uit zowel de rijen kolommen als vierkanten een zelfde getal komt
	gevondenGetallen = set(rijGetallen) & set(kolomGetallen) & set(vierkantGetallen)

	if len(gevondenGetallen) != 0:
		for x in gevondenGetallen:
			return x
	else:
		print ("Kan de sudoku helaas niet oplossen")
		sys.exit()

def print_sudoku(rijen):
	"""Print de sudoku uit"""
	for x in range(0, len(rijen)):
			for y in range(0, len(rijen[x])):
				print(rijen[x][y], end=" ")
			print()


# Uitvoeren van sudoku solver door de verschillende functies uit te voeren
rijen = lees_sudoku("sudoku.txt")
print("\nOnvoltooide Sudoku")
print_sudoku(rijen)

kolommen = kolommen_maker(rijen)
vierkanten = vierkanten_maker(rijen)
sudokuOpgelost = sudoku_oplosser(rijen, kolommen, vierkanten)

print("\nVoltooide Sudoku")
print_sudoku(sudokuOpgelost)

