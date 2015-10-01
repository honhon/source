#!/bin/sh

cd ~/
mkdir -p usr/local/src

### git ###
cd ~/usr/local/src
curl -O https://git-core.googlecode.com/files/git-1.9.0.tar.gz
#curl -x proxy:port -O https://git-core.googlecode.com/files/git-1.9.0.tar.gz
tar xvfz git-1.9.0.tar.gz
cd git-1.9.0
./configure --prefix=$HOME/usr/local/
make
make install

### tig ###
cd ~/usr/local/src
curl -O http://jonas.nitro.dk/tig/releases/tig-2.1.1.tar.gz
#curl -x proxy:port -O http://jonas.nitro.dk/tig/releases/tig-2.1.1.tar.gz
tar xvfz tig-2.1.1.tar.gz
cd tig-2.1.1
./configure --prefix=$HOME/usr/local/
make
make install

### vim ###
cd ~/usr/local/src
curl -O http://ftp.vim.org/pub/vim/unix/vim-7.4.tar.bz2
#curl -x proxy:port -O http://ftp.vim.org/pub/vim/unix/vim-7.4.tar.bz2
bzip2 -cd vim-7.4.tar.bz2 |tar xv
cd vim74
./configure --prefix=$HOME/usr/local/ --enable-multibyte
make
make install

### setting on login ###
vi ~/.zshrc
export PATH=~/usr/local/bin:$PATH
alias vi=vim

### python ###
cd ~/usr/local/src
curl -O https://www.python.org/ftp/python/2.7.9/Python-2.7.9.tgz
#curl -x proxy:port -O https://www.python.org/ftp/python/2.7.9/Python-2.7.9.tgz
tar xvfz Python-2.7.9.tgz
cd Python-2.7.9
./configure --prefix=$HOME/usr/local/
make
make install

### ruby ###
cd ~/usr/local/src
curl -O http://cache.ruby-lang.org/pub/ruby/2.2/ruby-2.2.2.tar.gz
#curl -x proxy:port -O http://cache.ruby-lang.org/pub/ruby/2.2/ruby-2.2.2.tar.gz
tar xvfz ruby-2.2.2.tar.gz
cd ruby-2.2.2
./configure --prefix=$HOME/usr/local/
make
make install

### capistrano ###
#export proxy:port
gem install capistrano

### fabric (& pip) ###
#export proxy:port
curl https://raw.github.com/pypa/pip/master/contrib/get-pip.py | python
pip install Fabric