def solve_ciph(string)
    upper_string = string.upcase

    for i in 0..25
        upper_string.each_char { |c|
            if c != " " 
                print (((c.ord-65 - i) % 26)+65).chr
            else
                print " "
            end
        }
        print("\n\n")
    end
end

def alphabet_creation(string)
    upper_string = string.upcase.delete(' ')

    whole_alphabet = [*('A'..'Z')]
    key_alphabet = []

    for i in 0..upper_string.length
        if whole_alphabet.include? upper_string[i]
            whole_alphabet.delete(upper_string[i])
            key_alphabet.append(upper_string[i])
        end
    end

    key_alphabet.concat(whole_alphabet)
    print(key_alphabet)
end

def decimate(key)
    (0..25).each { |i|
        print (((i*key)%26)+65).chr
    }

end

print decimate(4)
# solve_ciph("aopz pz hu jfwoly alza av joljr pm aol iybal mvyjly dvyrz")
# alphabet_creation("Alphabet Creation")