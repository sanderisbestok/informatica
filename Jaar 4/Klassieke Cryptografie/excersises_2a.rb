def freq_table(string)
    upper_string = string.upcase
    frequency_table = {}

    upper_string.each_char { |c|
        if frequency_table[c] 
            frequency_table[c] += 1
        else
            frequency_table[c] = 1
        end    
    }

    return frequency_table
end

def mult_inv(a)
    rold, rnew = a, 26
    sold, snew = 1, 0
    told, tnew = 0, 1

    while rnew != 0 do
        q = rold/rnew
        r = rold%rnew
        rold,rnew = rnew,r
        sold,snew = snew,sold-q*snew
        told,tnew = tnew,told-q*tnew
    end

    return sold
end

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

def ind_coi(string)
    string = string.gsub(/\s+/, "")
    string = string.gsub(/\n+/, "")

    frequency_table = freq_table(string)

    length = string.length
    alphabet_length = frequency_table.length

    num = 0.0
    den = 0.0

    frequency_table.each do |key, value|
        num += value * (value - 1)
        den += value
    end
        
    return num / (den * (den - 1))
end

def brute_affine(string)
    coprime = [3, 5, 7, 9, 11, 15, 17, 19, 21, 23, 25]
    inverses = []

    coprime.each do |c|
        inverses.append(mult_inv(c))
    end

    string = string.gsub(/\s+/, "")
    string = string.gsub(/\n+/, "")

    inverses.each do |i|
        for j in 0..25
            string.each_char do |c|
                print (((i * (c.ord-65 - j)) % 26)+65).chr
            end
            puts "\n\n"
        end
        puts "\n\n\n\n"
    end
end

string = "QBVDL WXTEQ GXOKT NGZJQ GKXST RQLYR
XJYGJ NALRX OTQLS LRKJQ FJYGJ NGXLK
QLYUZ GJSXQ GXSLQ XNQXL VXKOJ DVJNN
BTKJZ BKPXU LYUNZ XLQXU JYQGX NTYQG
XKXQJ KXULK QJNQN LQBYL OLKKX SJYQG
XNGLU XRSBN XOFUL YDSXU GJNSX DNVTY
RGXUG JNLEE SXLYU ESLYY XUQGX NSLTD
GQXKB AVBKX JYYBR XYQNQ GXKXZ LNYBS
LRPBA VLQXK JLSOB FNGLE EXYXU LSBYD
XWXKF SJQQS XZGJS XQGXF RLVXQ BMXXK
OTQKX VLJYX UQBZG JQXZL NG"

# puts ind_coi(string)
# puts solve_ciph(string)
# brute_affine(string)

string2 = "IW*CI W@G*L &H&L( ASN*A E)U&V $CNPC
SIW*E DDSA@ LTCIH !(A#C V%EIW *!#HA
*IW@N TAEHR $CI(C JTS!C SHDS# SIW@S
DVW@R G$HH* SIW*W )JH@( CUGDC IDUIW
*&AIP GWTUA TLS$L CIW*D IWTG! #HATW
TRG$H H*SQT U$G*I W@S)D GHWTR APBDG
*S%EI W@WDB @HIG@ IRWWX H&CV+ XHWVG
*LLXI WW#HE G)VG@ HHI#A AEGTH @CIAN
W*L!H Q%I!L )DAAN R)BTI B)K#C VXC#I
HDGQX ILXIW IW@VA *&B!C SIWTH E**S$
UA(VW I"

puts ind_coi(string2)


