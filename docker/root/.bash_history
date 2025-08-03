/usr/local/bin/composer install
cd /hleb
/usr/local/bin/composer install
[200~php vendor/bin/phinx status
php vendor/bin/phinx status
exit
cd /hleb
/usr/local/bin/composer install
/root/composer-shell.sh analyze
php vendor/bin/phinx status
exit
cd /hleb
php vendor/bin/phinx status
exit
cd /hleb
php /hleb/vendor/bin/phinx migrate -c /hleb/phinx.php -vvv
exit
ping db
cd /hleb
ping db
telnet db 3306
exit
cd /hleb
/usr/local/bin/composer install
docker-compose exec php php /hleb/vendor/bin/phinx status --configuration /hleb/phinx.php
exit
