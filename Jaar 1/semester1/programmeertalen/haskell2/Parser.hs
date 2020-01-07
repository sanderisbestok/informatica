-- Student: 		Sander Hansen
-- Student-ID: 		10995080
-- Programma:		Parser.hs
-- Beschrijving:	A parser for the ArnoldH Language, not 100% complete
module Parser where
import Ast

import Data.List
import Data.Char
import Data.Maybe

-- Identifiern samenwerking met Baran (Wisten niet hoe we moesten beginnen, daarna zelfstandig)
-- identifier dissects a name and gives an error if the name is not valid
identifier :: String -> String
identifier input
	| input == map toLower input 	= input
	| otherwise 					= error ("Could not parse identifier: " ++ input)

-- parseValue checks a value and returns an error if it can not be parsed
parseValue :: String -> Value
parseValue input
	| all isDigit input 			= IntVal (read input)
	| input == map toLower input	= Variable input
	| otherwise						= error ("Could not parse value: " ++ input)

-- parsePhrase checks if a line starts with a quote and will return the arguments given
parsePhrase :: String -> String -> Maybe [String]
parsePhrase phrase input
	| isPrefixOf phrase whiteSpaceRemoved	= Just (words(strippedInput))
	| otherwise								= Nothing
	where
		whiteSpaceRemoved = strip input
		strippedInput = drop (length phrase) whiteSpaceRemoved


-- Removing of whitespaces code from http://goo.gl/MKZViL
-- I could only use this self implemented strip function on my computer, because
-- my pc could not import the library with build in strip function.
-- Not all the students had this problem, if it will give error the function can be
-- removed and the build in function of strip should work.
strip :: String -> String
strip 	= unlines . map (dropWhile isSpace) . lines

-- Function with single parses input with a single argument to a maybe statement
parseWithSingle :: (String -> Statement) -> String -> String -> Maybe Statement
parseWithSingle f phrase input
	| (parsePhrase phrase input) == Nothing		= Nothing
	| length strippedInput /= 1 				= error ("Could not parse: " ++ phrase)
	| otherwise									= Just (f (strippedInput !!0))
	where
		strippedInput = fromJust (parsePhrase phrase input)

-- Function parses print statement
parsePrint :: String -> Maybe Statement
parsePrint = parseWithSingle (Print . parseValue) "IT'S SHOW TIME"

-- Function parses return statement
parseReturn :: String -> Maybe Statement
parseReturn = parseWithSingle (Return . parseValue) "HASTA LA VISTA BABY"

-- Function parses the if Header (rest of while will be delt with in another function)
-- Help for the list comperhension from Mike (told in pseudocode)
parseIfHeader :: String -> Maybe Statement
parseIfHeader = parseWithSingle (\x -> If (parseValue x) []) "BECAUSE I'M GOING TO SAY PLEASE"

-- Function parses the while Header (rest of while will be delt with in another function)
-- Help for the list comperhension from Mike (told in pseudocode)
parseWhileHeader :: String -> Maybe Statement
parseWhileHeader = parseWithSingle (\x -> While (parseValue x) []) "I'LL BE BACK"

-- Checks if function has a return of not
parseFunctionCall :: String -> Maybe Statement
parseFunctionCall input
	| isInfixOf "::" input 	= parseFunctionCallWithReturnVariable input
	| otherwise				= parseFunctionCallWithoutReturnVariable input

-- Parses function without return to a just statement
parseFunctionCallWithoutReturnVariable :: String -> Maybe Statement
parseFunctionCallWithoutReturnVariable input
	| isInfixOf "::" input 	= Nothing
	| otherwise				= Just (FunctionCall function arguments Nothing)
	where
		filteredInput = parsePhrase "DO IT NOW" input
		function = head (fromJust filteredInput)
		arguments = map parseValue (tail (fromJust filteredInput))

-- Parses function with return to a just statement
parseFunctionCallWithReturnVariable :: String -> Maybe Statement
parseFunctionCallWithReturnVariable input
	| isInfixOf "::" input 	= Just (FunctionCall function arguments (Just(result)))
	| otherwise				= Nothing
	where
		filteredInput = parsePhrase "DO IT NOW" input
		function = head (fromJust filteredInput)
		arguments = map parseValue (init(init(tail (fromJust filteredInput))))
		result = head (reverse(fromJust filteredInput))

-- Parses unary operators gives an exception if it cannot be parsed
parseUnary :: (String -> Value -> Statement) -> String -> String -> Maybe Statement
parseUnary f phrase input
	| (parsePhrase phrase input) == Nothing		= Nothing
	| length strippedInput /= 2 				= error ("Could not parse value: " ++ input)
	| otherwise									= (Just (f (strippedInput !!0)
	(parseValue (strippedInput !!1))))
	where
		strippedInput = fromJust (parsePhrase phrase input)

-- Parses Binary operators gives an exception if it cannot be parsed
parseBinary :: (String -> Value -> Value -> Statement) -> String -> String -> Maybe Statement
parseBinary f phrase input
	| (parsePhrase phrase input) == Nothing		= Nothing
	| length strippedInput /= 3 				= error ("Could not parse value:  "++ input)
	| otherwise									= (Just (f (strippedInput !!0)
	(parseValue (strippedInput !!1)) (parseValue (strippedInput !!2))))
	where
		strippedInput = fromJust (parsePhrase phrase input)

-- parseChoice applies input on a list of parses and gives the first result
-- back or Nothing of no result is found.
parseChoice :: [String -> Maybe a] -> String -> Maybe a
parseChoice parsers input
	| length(justValues) == 0	= Nothing
	| otherwise					= listToMaybe justValues
	where
		results = map (\x -> x input) parsers
		justValues = catMaybes results

-- parseOperation will match quotes with actual operators
parseOperation :: String -> Maybe Statement
parseOperation input =
	parseChoice [parseBinary (Add) "GET UP",
	parseBinary (Min) "GET DOWN",
	parseBinary (Mult) "YOU'RE FIRED",
	parseBinary (Div) "HE HAD TO SPLIT",
	parseBinary (Or) "CONSIDER THAT A DIVORCE",
	parseBinary (And) "KNOCK KNOCK",
	parseBinary (Less) "LET OFF SOME STEAM BENNET",
	parseUnary (Set) "YOU SET US UP",
	parseUnary (Not) "I LIED"] input

-- parseSingle will match input with single argument with the quotes
-- (which are defined in the functions)
parseSingle :: String -> Statement
parseSingle input =
	fromJust (parseChoice [parsePrint, parseReturn, parseIfHeader, parseWhileHeader] input)

parseBlock :: Int -> [String] -> [Statement] -> ([Statement], [String])
parseBlock _ [] rs = undefined
parseBlock indentLevel (line:rest) rs = undefined

parseFunctions :: [String] -> [FunctionPrototype] -> [FunctionPrototype]
parseFunctions [] rs = undefined
parseFunctions (line:rest) rs = undefined

parseProgram :: String -> [FunctionPrototype]
parseProgram input = undefined