#Dit script vraagt om invoer, en kijkt of deze invoer voorkomt in het bestand
#/etc/passwd, en print dit bestand op de regels die de invoer bevatte na
#als de invoer er in voorkwam wordt de invoer met een bericht geprint
echo What is your name?
echo What is your name?
while [[ ${#naam} -eq 0 ]]; do
	read -r naam
done
	naamup="${naam^^}"

#Print de regels uit (checkt alles met hoofdletter, print zonder)
while read line; do
	if [[ ${line^^} == *"$naamup"* ]]; then
		gefilterd="true"
	else
		echo "$line"
	fi
done < /etc/passwd

if [[ "$gefilterd" == "true" ]]; then
	echo "Hello $naam!"
fi
