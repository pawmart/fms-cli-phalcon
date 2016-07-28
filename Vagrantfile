# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
      # Customize the amount of memory on the VM:
      vb.memory = "4096"
  end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
    config.vm.provision "shell", inline: <<-SHELL
sudo apt-get update
sudo apt-get install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php

sudo apt-get update

sudo apt-get install -y --allow-unauthenticated \
	php7.0-fpm \
	php7.0-cli \
	php7.0-curl \
	php7.0-gd \
	php7.0-intl \
	php7.0-zip \
	php7.0-pgsql \
	build-essential \
	git \
	gcc \
	make \
	re2c \
	libpcre3-dev \
	php7.0-dev

# Install composer
sudo curl -sS http://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install zephir
sudo composer global require "phalcon/zephir:dev-master"

# Install phalconphp with php7
sudo git clone https://github.com/phalcon/cphalcon -b 2.1.x --single-branch

cd cphalcon/

sudo ~/.composer/vendor/bin/zephir build --backend=ZendEngine3
sudo echo "extension=phalcon.so" >> /etc/php/7.0/fpm/conf.d/20-phalcon.ini

# some additional php settings if you care
sudo sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.0/cli/php.ini
sudo sed -i "s/memory_limit = 128M/memory_limit = 256M /g" /etc/php/7.0/fpm/php.ini

# restart php-fpm
sudo service php7.0-fpm restart
    SHELL
end