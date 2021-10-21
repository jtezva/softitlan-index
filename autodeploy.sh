#!/bin/bash##
git checkout master
git config --global credential.helper store
git pull origin master
cat banner.txt
cd ~/project/softitlan-index
sudo cp -r resources index.html /var/www/html
echo "\n Se realiza el deploy de index Softitlan"

listaArchivos=`ls ~/project/softitlan-index/science`
sudo cp -r $listaArchivos /var/www/html/science
echo "Se realiza el deploy de ciencia"