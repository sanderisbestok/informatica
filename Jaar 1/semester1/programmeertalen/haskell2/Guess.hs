-- Student: 		Sander Hansen
-- Student-ID: 		10995080
-- Programma:		Parser.hs
-- Beschrijving:	A Guessing game
module Guess where

import Data.Char
import Data.Maybe

-- Check if input is number
isNum :: String -> Bool
isNum = all(isDigit)

-- Get number from IO
getNum :: String -> IO Int
getNum prompt = do
	putStrLn prompt
	number <- getLine

-- Check if the input is a number, if not ask again
	case isNum number of
		True 		-> return (read number)
		otherwise	-> getNum prompt

-- Check if the answer is wright if not call checkproximity function
checkAnswer :: Int -> Maybe Int -> Int -> IO ()
checkAnswer secret previous current
	| secret == current 	= putStrLn "You've won the game!"
	| otherwise				= checkProximity secret previous current

-- Calculate if closer or further away from answer
checkProximity :: Int -> Maybe Int -> Int -> IO ()
checkProximity secret Nothing current = guessingGame' secret (Just current)
checkProximity secret (Just previous) current
	| abs (secret - previous) < abs (secret - current) = do
		putStrLn "You're Colder!"
		guessingGame' secret (Just current)
	| abs (secret - previous) > abs (secret - current) = do
		putStrLn "You're Warmer!"
		guessingGame' secret (Just current)
	| otherwise = do
		putStrLn "You're not warm, you're not cold"
		guessingGame' secret (Just current)

-- Guessing game asks for guess
guessingGame' :: Int -> Maybe Int -> IO ()
guessingGame' secret previous = do
	current <- (getNum "What's your guess?")
	checkAnswer secret previous current

-- Start guessing game with given number call up the game
guessingGame :: Int -> IO ()
guessingGame secret = guessingGame' secret Nothing

