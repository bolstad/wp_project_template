#!/usr/bin/env bash

DBHOST=localhost
DBNAME=wpsite
DBUSER=root
DBPASSWD=root

# TODO: fixa pipe här 
echo "blankspot-dev" | sudo tee /etc/hostname
echo "127.0.1.1 wpprojecttemplate"  | sudo tee -a /etc/hosts

sudo /etc/init.d/hostname.sh 

mkdir /home/vagrant/uploads
sudo chown www-data:www-data /home/vagrant/uploads
sudo chmod a+rw /home/vagrant/uploads
ln -s /home/vagrant/uploads /vagrant/www/content/media 

sudo apt-get -y update
sudo apt-get -y upgrade
sudo apt-get -y install php5 php-pear  php-apc git curl screen php5-cli php5-curl php5-xdebug git-cvs php5-memcached  memcached

### From Installing Composer

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer


### From Installing Composer

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

### From Installing MySQL

sudo debconf-set-selections <<< 'mysql-server \
 mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server \
 mysql-server/root_password_again password root'
sudo apt-get install -y php5-mysql mysql-server

cat << EOF | sudo tee -a /etc/mysql/conf.d/default_engine.cnf
[mysqld]
default-storage-engine = MyISAM
EOF

sudo service mysql restart

mysql -uroot -p$DBPASSWD -e "CREATE DATABASE $DBNAME"
mysql -uroot -p$DBPASSWD -e "grant all privileges on $DBNAME.* to '$DBUSER'@'localhost' identified by '$DBPASSWD'"

echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | sudo debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password $DBPASSWD" | sudo debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password $DBPASSWD" | sudo debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password $DBPASSWD" | sudo debconf-set-selections
echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect none" | sudo debconf-set-selections
sudo apt-get -y install phpmyadmin 


echo -e "\n--- Allowing Apache override to all ---\n"
sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf
sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/sites-enabled/000-default 

echo -e "\n--- Setting document root to public directory ---\n"
sudo rm -rf /var/www
sudo ln -fs /vagrant/www /var/www
 
echo -e "\n--- We definitly need to see the PHP errors, turning them on ---\n"
sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini

echo -e "\n\nListen 81\n" | sudo tee -a /etc/apache2/ports.conf

cat > /tmp/phpmyadmin.conf << "EOF"
<VirtualHost *:81>
    ServerAdmin webmaster@localhost
    DocumentRoot /usr/share/phpmyadmin
    DirectoryIndex index.php
</VirtualHost>
EOF
sudo mv /tmp/phpmyadmin.conf /etc/apache2/sites-enabled/phpmyadmin.conf

### From Installing Apache

sudo apt-get install -y apache2 libapache2-mod-php5
sudo a2enmod rewrite
sudo service apache2 restart



# Create folders for uploads and blog dir. Set owner to www-data.
printf "Create uploads folder\n"
sudo mkdir -p /opt/wordpress_install/

if [ -d /vagrant/www/content/uploads ]; then
  sudo rm -rf /vagrant/www/content/uploads || print_warning "\nCannot remove existing WP uploads folder. You need to remove it manually\n"
fi

# Symlink uploads and blogs.dir to wp-content
if [ ! -h /vagrant/www/content/uploads ]; then
  if [ ! -d /opt/wordpress_install/uploads ]; then
    sudo mkdir -p /opt/wordpress_install/uploads
  fi
  sudo ln -s /opt/wordpress_install/uploads /vagrant/www/content/ && printf "\nCreated symlink to /opt/wordpress_install/uploads\n"
  sudo chmod 777 -R /opt/wordpress_install/uploads && printf "\nSetting up 0777 permission on /opt/wordpress_install/uploads...\n"
  sudo chmod 777 -R /vagrant/www/content/uploads && printf "\nSetting up 0777 permission on /vagrant/www/content/uploads...\n"
fi
