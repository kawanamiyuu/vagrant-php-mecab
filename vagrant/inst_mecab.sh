#!/bin/bash

#
# @see http://mecab.googlecode.com/svn/trunk/mecab/doc/index.html#install-unix
#

MECAB="mecab-0.996"
IPADIC="mecab-ipadic-2.7.0-20070801"
INSTALL_DIR=/usr/local/opt

#
# install mecab
#
inst_mecab() {
  wget https://mecab.googlecode.com/files/${MECAB}.tar.gz
  tar xzvf ${MECAB}.tar.gz
  pushd ${MECAB}
  ./configure \
    --with-charset=utf8 \
    --enable-utf8-only \
    --prefix=${INSTALL_DIR}/${MECAB}
  make
  make install
  popd

  # create symlink
  pushd /usr/local/bin
  ln -s ${INSTALL_DIR}/${MECAB}/bin/mecab mecab
  ln -s ${INSTALL_DIR}/${MECAB}/bin/mecab-config mecab-config
  popd
}

#
# install IPA dictionary
#
inst_ipadic() {
  wget https://mecab.googlecode.com/files/${IPADIC}.tar.gz
  tar xzvf ${IPADIC}.tar.gz
  pushd ${IPADIC}
  ./configure \
    --with-charset=utf8 \
    --with-mecab-config=/usr/local/bin/mecab-config
  make
  make install
  popd
}


# =================================
# main
# =================================

pushd /tmp

[ ! -d $INSTALL_DIR ] && mkdir $INSTALL_DIR
inst_mecab
inst_ipadic

popd
