#Dit script vraagt om invoer, en returned de invoer maar vervangt
#elke entry van het laatste karakter met een underscore
echo What is your name?
while [[ ${#naam} -eq 0 ]]
do
	read -r naam
done
	laatstekarakter="${naam: -1}"
	echo "Hello ${naam//$laatstekarakter/_}!"