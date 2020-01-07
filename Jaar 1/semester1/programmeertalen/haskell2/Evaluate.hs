module Evaluate where
import Ast

import Data.Maybe
import qualified Data.Map.Strict as Map

-- the first argument is the stack of scopes, the second is a map containing the
-- the function definitions. The top of the stack is given by the head of the list.

data ProgramState = ProgramState [Map.Map String Int] (Map.Map String FunctionPrototype) deriving (Show, Eq)

emptyProgramState :: ProgramState
emptyProgramState = ProgramState [Map.empty] Map.empty

getVar :: ProgramState -> String -> Maybe Int
getVar = undefined

setVar :: ProgramState -> String -> Int -> ProgramState
setVar = undefined

getFunction :: ProgramState -> String -> Maybe FunctionPrototype
getFunction = undefined

addFunction :: ProgramState -> FunctionPrototype -> ProgramState
addFunction = undefined

popScope :: ProgramState -> ProgramState
popScope = undefined

emptyScope :: ProgramState -> ProgramState
emptyScope = undefined

pushNewScope :: ProgramState -> ProgramState
pushNewScope = undefined

isVarDefined :: ProgramState -> String -> Bool
isVarDefined = undefined

isFunctionDefined :: ProgramState -> String -> Bool
isFunctionDefined = undefined

getValue :: ProgramState -> Value -> Int
getValue = undefined

evalBinary :: ProgramState -> Statement -> ProgramState
evalBinary = undefined

evaluateBlock :: ProgramState -> [Statement] -> IO (ProgramState, Maybe Int)
evaluateBlock = undefined

evaluateProgram :: [FunctionPrototype] -> IO (ProgramState, Maybe Int)
evaluateProgram = undefined
