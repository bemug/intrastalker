#!/bin/bash

#Original by coutelot
#Tweaks by bemug

#scan les intrapc de a a b.
#augmenter STEP en cas de probleme de fork
a=10
b=300
STEP=2

#scan une plage d'intrapc du premier argument au deuxieme argument
function scan
{
	i=$1
	while test $i -le $2;
	do r=$(ping -c 1 -w 1 intrapc$i 2> /dev/null | grep rtt | wc -l);
		if [[ $r == 1 ]]
		then
			#On demande qui c'est
			WHO="$(ssh -o StrictHostKeyChecking=no -o LogLevel=quiet intrapc$i  w -h)"
			#StrictHostKeyChecking=no : Force autorisation de la clé
			#LogLevel=quiet : Evite les messages (exemple on vient d'ajouter la clé)
			#w : -s = short -h retire le header
			if [[ -z "$WHO" ]] ; then
				echo -e "intrapc$i\n"
			else
				echo -e "intrapc$i"
				echo -e "$WHO\n"
			fi
		fi
		i=$(($i+1));
	done
}

#lance des scans en parallel
function parallelscan
{
	PIDS=""
	i=$a
	while test $i -le $b
	do
		scan $i $(($i+$STEP))&
		PIDS="$PIDS $!"
		i=$(($i+$STEP+1));
	done

	#on attend que tout ait ete termine avant de rendre la main
	for i in $PIDS
	do
		wait $i
		#echo $i
	done
}

echo `date`
parallelscan
