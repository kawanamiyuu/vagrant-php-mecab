#!/bin/bash

MECAB_CONFIG=/usr/local/bin/mecab-config
PHP_CONFIG=/usr/bin/php-config

#
# install php-mecab extension v0.5.0 (versionは2013/12現在)
#
inst_php_mecab() {
  git clone https://github.com/rsky/php-mecab.git
  pushd php-mecab/mecab
  phpize
  ./configure \
    --with-php-config=${PHP_CONFIG} \
    --with-mecab=${MECAB_CONFIG}
  make
  make install
  popd
}


# ====================================
# main
# ====================================

pushd /tmp

inst_php_mecab

popd

# modify .ini
echo "extension=mecab.so" > /etc/php.d/mecab.ini
