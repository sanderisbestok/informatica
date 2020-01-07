module Ast where

type Name = String
data Value = Variable Name
           | IntVal Int deriving (Show, Eq)

data Statement = If Value [Statement]
               | While Value [Statement]
               | Return Value
               | FunctionCall Name [Value] (Maybe Name)
               | Print Value

               -- binary operators
               | Add  Name Value Value
               | Min  Name Value Value
               | Mult Name Value Value
               | Div  Name Value Value
               | Less Name Value Value
               | And  Name Value Value
               | Or   Name Value Value

               -- unary operators
               | Not Name Value
               | Set Name Value
               deriving (Show, Eq)

data FunctionPrototype = FunctionPrototype Name [Name] [Statement] deriving (Show, Eq)

getFunctionName :: FunctionPrototype -> Name
getFunctionName (FunctionPrototype name _ _) = name

