#Dit script vraagt om invoer, en returned de invoer maar vervangt
#elke entry van het laatste karakter met een underscore onafhankelijk van case
echo What is your name?
echo What is your name?
while [[ ${#naam} -eq 0 ]]
do
	read -r naam
done
	laatstekarakter="${naam: -1}"
	laatstekarakterup="${laatstekarakter^^}"
	laatstekarakterlow="${laatstekarakter,,}"
	echo "Hello ${naam//[$laatstekarakterup$laatstekarakterlow]/_}!"