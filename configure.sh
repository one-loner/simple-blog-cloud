#!/bin/bash
read -p "Enter name of you blog: " n
read -p "Enter description of your blog: " d
read -p "Enter access token to your blog or press enter to generate random: " t
if [ -z "$n" ] || [ -z "$d" ]; then
    echo "Name and decsription of blog can't be empty."
    exit 1
fi

if [ -z "$t" ]; then
t=$(< /dev/urandom tr -dc 'A-Za-z0-9' | head -c 16)
echo "Your token is $t"
echo ""
fi
sed -i "s/Standalone blog/$n/g" index.php
sed -i "s/Decription/$d/g" index.php
sed -i "s/Standalone blog/$n/g" admin.php
mv admin.php $t.php
echo "Done. To manage your blog go to <blog.url>/$t.php"

