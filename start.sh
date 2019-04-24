#!/usr/bin/env sh
sudo service mysql start
php -S localhost:9000 -t /home/yoyote/Documents/Adminer/ 1>/dev/null 2>/dev/null &
php extra/init-db.php
php -S localhost:4000 -t public public/index.php
