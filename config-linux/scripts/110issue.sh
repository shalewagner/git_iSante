#!/bin/sh -vx

. ./script-functions.sh

issueFile=/etc/issue
divert $issueFile

esc="\033["
#clear the screen
echo -ne "${esc}H${esc}J" > $issueFile

#add contents of original issue file
cat $issueFile.distrib >> $issueFile

#the rest is our content
echo -ne " --- ${esc}40;31;1mAVERTISSEMENT${esc}0m ---\n" >> $issueFile

cat >> $issueFile <<EOF
Un arrêt inapproprié du système peut entraîner une perte de données et peut l'endommager de façon
permanente. Voici la procédure à suivre pour arrêter le système proprement :

1. Ouvrez l'écran "confconsole" en appuyant sur ALT+F8.
2. Appuyez sur "Enter" pour sélectionner "Advanced Menu".
3. Utilisez la touche flèche vers le bas pour sélectionner "Shutdown" et appuyez sur "Enter".
4. Appuyez sur "Enter" pour confirmer l'arrêt. Le système s'éteindra automatiquement.

A noter également qu'une panne de courant se traduira par un arrêt innapproprié du système. Pour
éviter cela, nous vous prions de faire en sorte que le système soit connecté à un ASI dédié et que
le cable de données ASI soit correctement installé.

EOF

echo -ne " ------ ${esc}40;31;1mWARNING${esc}0m ------\n" >> $issueFile
cat >> $issueFile <<EOF
Shutting down the system improperly can result in data loss and can damage the system
permanently. Here is the correct procedure for shutting down the system.

1. Switch to the "confconsole" screen by pressing ALT+F8.
2. Press "Enter" to select "Advanced Menu".
3. Use the down arrow key to select "Shutdown" and press "Enter".
4. Press "Enter" again to confirm the shutdown. The system will automatically power down.

Also note that a power failure will result in an improper shutdown of the system. To avoid this
please ensure that the system is attached to a dedicated UPS and that the UPS data cable is
installed properly.

 ---------------------
ALT+F1 -> login
ALT+F8 -> confconsole

EOF
