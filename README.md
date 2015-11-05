# phalcon_rest
Use Phalcon and {JSON:API} to make your own server

This project demonstrates how to use the Palcon + {JSON:API} project. 
It is a working example that pulls a the composer package into a Phalcon application. 
The demo app is backed by a sqllite database but any SQL RDBMS should do.


###Before you install, check this list:
1) Install [Phalcon](https://github.com/gte451f/phalcon-json-api.git) to your webserver.  You installed a webserver with PHP right?

2) Make sure [Composer](https://getcomposer.org/) is installed 


###Steps to install this application:
These instructions skip some server specific factors and assumes you are installing this application to the root directory of your webserver.

1) Download this project files to your local web server.  
    git clone https://github.com/gte451f/phalcon-json-api.git
 
 
2) Run the following from inside your newly installed application:
    composer install; composer dumpautoload -o;
        
3) Setup your webserver for Phalcon usage. 
See here for [Apache](https://docs.phalconphp.com/en/latest/reference/apache.html) and here for [Nginx](https://docs.phalconphp.com/en/latest/reference/nginx.html)



For more information, visit the [Phalcon + {JSON:API}](https://github.com/gte451f/phalcon-json-api-package) project.
