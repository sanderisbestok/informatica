#!/usr/bin/env ruby

Alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"

# Print uppercase characters
puts(Alphabet)

# Alternative way
('A'..'Z').each { |c|
  print c
}
puts

# Or
(0..25).each { |i|
  print (i+65).chr
}
puts

# Or
(0...26).each { |i|
  print (i+65).chr
}
puts

# Print lowercase characters

('a'..'z').each { |c|
  print c
}
puts

# What about this?
# Expect more...

('A'..'z').each { |c|
  print c
}
puts

# Expect less...
('a'..'Z').each { |c|
  print c
}
puts

# Print in reverse order
puts Alphabet.reverse