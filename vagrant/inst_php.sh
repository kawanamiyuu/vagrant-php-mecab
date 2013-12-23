#!/bin/bash

# install epel repository
rpm -Uvh http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm

# install remi repository
rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm

# install php
yum --enablerepo=remi,remi-php55 install -y php php-devel

