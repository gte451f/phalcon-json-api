# phalcon_rest
Use Phalcon and {JSON:API} to make your own server

This project demonstrates how to use the [Phalcon + {JSON:API}](https://github.com/gte451f/phalcon-json-api-package) project. 
It is a working example that pulls a the composer package into a Phalcon application. 
The demo app is backed by a sqlite database but any SQL RDBMS should do.

To see a more full featured application that runs on the Phalcon + {JSON:API} package, visit [Smores.camp](http://smores.camp).
 

### Docker Demo
This repository includes a docker-compose file that makes it super easy to demo the application.

1. Install Docker (Check the internet for help on that one)
2. Clone the repo and from inside it run 
```
docker-compose up;
```
3. Visit localhost:8080

### Manual Installation
1) Install [Phalcon](https://github.com/gte451f/phalcon-json-api.git) on your webserver.  You installed a webserver with PHP 7 right?

2) Make sure [Composer](https://getcomposer.org/) is installed 

3) This demo application uses an sqlite database for persistent storage.  Make sure that PDO support for sqlite is installed.

something like...
```
sudo apt-get install php7-sqlite;
```


###Steps to install this application:
These instructions skip some server specific factors and assumes you are installing this application to the root directory of your webserver.

1) Download this project files to your local web server.  
```
git clone https://github.com/gte451f/phalcon-json-api.git
```
 
2) Run the following from inside your newly installed application:
```    
composer install;
```
        
3) Setup your webserver for Phalcon usage. 
See here for [Apache](https://docs.phalconphp.com/en/latest/reference/apache.html) and here for [Nginx](https://docs.phalconphp.com/en/latest/reference/nginx.html)


###To test:

Vist your application and you should see something like this:

```
{"GET":
    ["\/v1\/addresses",
    "\/v1\/addresses\/{id:[0-9]+}",
    "\/v1\/customers",
    "\/v1\/customers\/{id:[0-9]+}",
    "\/v1\/users",
    ...
```

Try out different end points like: /v1/addresses
```
{	"addresses": [
	{
    	"user_id": "15",
    	"id": "1",
    	"street": "123 Easy Street",
    	"state": "Oregon",
    	"zip": "24901",
    	"city": "Eugene"
	}....
```

For more information on the package itself, visit the [Phalcon + {JSON:API}](https://github.com/gte451f/phalcon-json-api-package) project.
