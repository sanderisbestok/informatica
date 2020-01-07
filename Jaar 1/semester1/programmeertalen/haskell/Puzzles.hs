-- Student: 		Sander Hansen
-- Student-ID: 		10995080
-- Programma:		Puzzles.hs
-- Beschrijving:	Verschillende functies ge- en herschreven voor Haskell.
module Puzzles

where

-- Eigen implicatie van Length
my_length :: [a] -> Integer
my_length = foldr (\_ x -> 1 + x) 0

-- Eigen implicatie van elem
my_elem :: (Eq a) => a -> [a] -> Bool
my_elem x = foldr (\y z -> y == x || z) False

-- Eigen implicatie van or
my_or :: [Bool] -> Bool
my_or = foldr (\x z -> x || z) False

-- Eigen implicatie van map
my_map :: (a -> b) -> [a] -> [b]
my_map f = foldr (\x z -> f x : z) []

-- Eigen implicatie van ++
my_plusplus :: [a] -> [a] -> [a]
my_plusplus a b = foldr (\x z -> x : z) b a

-- Eigen implicatie van reverse (Met foldr)
my_reverse :: [a] -> [a]
my_reverse = foldr (\x z -> z++[x]) []

-- Eigen implicatie van reverse (Met foldl)
my_reverse2 :: [a] -> [a]
my_reverse2 = foldl (\x z -> z : x) []

-- Kijkt of invoer Palindroom is
isPalindrome :: (Eq a) => [a] -> Bool
isPalindrome a = (reverse a) == a

-- Fibonacci, beginnen met 1 en dan volgens het algorithme van fibonacci
-- https://goo.gl/iDhbx1 telkens optellen zo wordt de fibonacci reeks geprint
fibonacci = 1 : scanl (+) 1 fibonacci