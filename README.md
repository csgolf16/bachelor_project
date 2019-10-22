Source from https://www.masterzendframework.com/docker-development-environment/

### LEMP Stack
---
Linux, Nginx, MariaDB, and PHP environment stack.

### Setup
---
```
docker-compose up -d
```

### What this stack provides?
---
* `html` folder contains root of application.
* default port for web is `80`.
* default port for database (mariadb) is `3306`.
* Default port for phpmyadmin is `8000`.
* Database is initializable like creating tables or adding default data to database by editing migration script to `./docker/mariadb/migration.sql`.

### Login
---
* username: root  
* password: rootpassword  

### Additional
---
Putty (Windows) 
* Enter Host Name (or IP address) : %IP_ADDRESS%
* Enter Port : 22
* Connection type : SSH 

Terminal (Mac, Linux) 
* ssh root@%IP_ADDRESS%

FileZilla 
* Enter Host : %IP_ADDRESS%
* Enter Username : root
* Enter Password : %ROOT_PASSWORD%
* Enter Port : 22

Digitalocean
* apt-get update, sudo apt-get update
* apt-get install git, sudo apt-get get install git
* apt-get upgrade, sudo apt-get upgrade
* mk dir %DIRECTORY_NAME%
* rm -rf %DIRECTORY_NAME%

Git 
* git init
* git add .
* git commit -m "%COMMIT_MESSAGE%"

Docker
* docker version
* docker-compose version
* docker-machine ip
* docker stats -a

* docker images
* docker rmi %IMAGE_ID%

* docker-compose start, docker-compose start %SERVICE_NAME%
* docker-compose stop, docker-compose stop %SERVICE_NAME%
* docker-compose up -d 
* docker-compose down

* docker start %CONTAINER_ID%
* docker stop %CONTAINER_ID%
* docker ps -a
* docker rm %CONTAINER_ID%

* docker-compose log, docker-compose log %SERVICE_NAME%