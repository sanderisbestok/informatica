#Dit script vraagt om invoer, en returned de invoer maar vervangt
#elke klinker met een underscore
echo What is your name?
echo What is your name?
while [[ ${#naam} -eq 0 ]]
do
	read -r naam
done
	echo "Hello ${naam//[eyuioaEYUIOA]/_}!"