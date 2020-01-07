#Dit script vraagt om invoer, en kijkt of deze invoer voorkomt in het bestand
#/etc/passwd, en print dit bestand op de regels die de invoer bevatte na
#als de invoer er in voorkwam wordt de invoer met een bericht geprint
echo What is your name?
while [[ ${#naam} -eq 0 ]]; do
	read -r naam
done

grep -i -v "$naam" "/etc/passwd"
echo

if grep -i -q "$naam" "/etc/passwd"; then
	echo "Hello $naam!"
fi
