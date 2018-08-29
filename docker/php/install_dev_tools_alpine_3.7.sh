apk update
echo "y" | apk add alpine-sdk mc vim git wget php7-dev autoconf
wget https://xdebug.org/files/xdebug-2.6.0.tgz
tar -xvzf xdebug-2.6.0.tgz
cd xdebug-2.6.0
phpize
./configure
make && make install
cd ..
rm -rf ./xdebug-2.6.0
rm xdebug-2.6.0.tgz
rm package.xml
php -i | grep xdebug
