#!/bin/bash##
git checkout master
git config --global credential.helper store
git pull origin master
cat banner.txt
cd ~/project/softitlan-index
cp index.html /var/www/html
echo "Se realiza el deploy de index Softitlan"
cd science
cp index.html /var/www/html/science
echo "Se realiza el deploy de ciencia"