#Dit script vraagt net zo lang om invoer tot er iets in is gevoerd
#en returned vervolgens een bericht met de invoer
echo What is your name?
while [[ ${#naam} -eq 0 ]]
do
	read -r naam
done
	echo Hello $naam!