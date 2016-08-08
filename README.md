# NFe Test
#install
```shell
cd /var/www
$ git clone https://github.com/Ferreiramg/nfe.git
$ nfe/composer update
```
##config
    Arquivo configuração na pasta ``config/api.conf.public.php``, para definições
#test
```shell
cd /var/www/nfe
$ phpunit -c phpunit.xml.dist test/src
```
