module Main where
import Ast
import Parser
import Evaluate

import System.Environment

main :: IO ()
main = do
  args <- getArgs
  case args of
    []  -> putStrLn "Not enough arguments given"
    _   -> do
      content <- readFile (head args)
      -- uncomment line to print content of file
      -- putStrLn content

      -- uncomment line when parser is done
      -- let program = parseProgram content
      -- uncomment line to print the parsed program
      -- print program

      -- uncomment line when evaluateProgram is done
      -- evaluateProgram program

      return ()
