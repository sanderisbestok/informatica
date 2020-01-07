-- Student: 		Sander Hansen
-- Student-ID: 		10995080
-- Programma:		MM.hs
-- Beschrijving:	Programma geeft feedback op de manier van Mastermind (d.m.v
--					zwarte en witte pinnen) Programma kan een functie raden als
--					er een patroon van kleuren opgegeven wordt. Bevat een benchmark
--					in hoeveel pogingen het programma het algoritme kan oplossen.
module MM

where

import Data.List
import Control.Monad (replicateM)

data Color = Red | Yellow | Blue | Green | Orange | Purple
	deriving (Eq,Show,Bounded,Enum)

type Pattern = [Color]

--				(# Black, # White)
type Feedback = (Int, Int)

-- Gegeven code voor de lijst met alle mogelijkheden
colors :: [Color]
colors = [minBound..maxBound]

store = replicateM 4 colors

-- Als deze functie wordt aangeroepen met twee patronen wordt er feedback in de vorm
-- van twee ints teruggegeven.
reaction :: Pattern -> Pattern -> Feedback
reaction lijst1 lijst2 = (zwart lijst1 lijst2, wit lijst1 lijst2)

-- Functie die lijst filtert of een bepaald item voorkomt in beide lijsten, zoja
-- returned lijst die niet gelijke elementen bevat. 4 - de lengte van deze lijst is
-- de hoeveelheid gelijke elementen. - de hoeveelheid zwarte pionnen om dubbele
-- te voorkomen.
wit :: Pattern -> Pattern -> Int
wit lijst1 lijst2 = 4 - length (lijst1 \\ lijst2) - zwart lijst1 lijst2

-- Vergelijkt elk element 1 met element 1 uit de andere lijst. Filtert vervolgens
-- de lijst op True, 4 - lengte van de gefilterde lijst is de hoeveelheid exacte matches.
zwart :: Pattern -> Pattern -> Int
zwart lijst1 lijst2 = 4 - length ([True,True,True,True] \\ (zipWith (==) lijst1 lijst2))

-- Naive algoritme roept functie op met de lijst met alle mogelijk heden en een lege lijst.
naive_algorithm :: Pattern -> [Pattern]
naive_algorithm secret = filterstore secret store []

-- De filterstore functie is een recursieve functie die vergelijkt het patroon van de secret met
-- een patroon uit store
filterstore :: Pattern -> [Pattern] -> [Pattern] -> [Pattern]
filterstore secret store oplossing
	-- Als de reactie 4,0 is dan is het algoritme klaar, en is de goede oplossing het laatste item
	-- in de lijst.
	| (reaction secret (head store)) == (4,0) = (head store) : oplossing
	-- Als de oplossing niet 4,0 was een nieuwestore aanmaken met opties die bij de feedback passen
	-- de head van de store toevoegen aan de oplossing lijst. Met de nieuwestore filterstore opnieuw
	-- aanroepen.
	| otherwise = (filterstore secret nieuwestore) ((head store) : oplossing)
	-- nieuwstore is de oude store maar dan gefilterd met nagemaakte filter functie
	-- standaard filter werkt niet omdat er nog om feedback gevraagt moet worden.
	where nieuwestore = [ x | x <- store, (reaction (head store) x) ==
		(reaction secret (head store))]

-- Elk element van store door het algorithme laten lopen, telkens het aantal pogingen
-- voordat het geraden is bij elkaar optellen. (d.m.v lengte) Als dit met alle elementen
-- van store is gedaan dit delen door lengte van store. Kan met elk algorithme getest worden
-- door variabele naam te veranderen.
tester :: (Pattern -> [Pattern]) -> Double
tester naive_algorithm = fromIntegral(sum [length (naive_algorithm x) | x <- store ]) / (fromIntegral(length store))
-- elke head van store kijken hoeveel het kost telkens optellen / totale lengte van store.
