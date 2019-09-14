#!/usr/bin/env bash

#== Bash helpers ==

function info {
  echo " "
  echo "--> $1"
  echo " "
}

#== Provision script ==

info "Provision-script user: `whoami`"

info "Restart web-stack"
service php7.0-fpm restart
service nginx restart
service mysql restart

echo -e "\n--- Apply migrations ---\n"
cd /app
./yii migrate --interactive=0
./tests/bin/yii migrate --interactive=0
