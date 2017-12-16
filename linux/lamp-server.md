yum update
yum upgrade
yum upgrade -y

rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm

yum install php70w php70w-opcache
yum install php70w-fpm php70w-opcache

yum install php-common
yum replace php-common --replace-with=php70w-common

yum install php70w-pear
yum install php70w-soap
yum install php70w-cli
yum install php70w-opcache

nano /etc/yum.repos.d/MariaDB.repo

====================================
[mariadb]
name = MariaDB
baseurl = http://yum.mariadb.org/10.0/centos6-amd64
gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB
gpgcheck=1
====================================

yum install MariaDB-server MariaDB-client -y
service mysql start

mysql -u root -p

mysql_secure_installation
chkconfig mysql on

service mysql restart