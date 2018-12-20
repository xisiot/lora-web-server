# lora-web-server

This web page is used to register applications, gateways, and devices. After successful registration, it will return the AppEUI of the application, the gatewayId of the gateway, and the DevEUI of the device. Users need these important fields when using the server. At the same time, the web page is based on Laravel framework, which is one of php frameworks. The database uses MySQL and MongoDB, and these development environments need to be installed first.

#### 1 Environment installation

##### 1.1 Apache(version:2.4.*  recommend: 2.4.7)

- Enter the update check command at the terminal: 

  ```shell
  sudo apt-get update
  ```

- After the update is completed (if you don't want to check for updates, you can enter this step directly), enter:

  ```shell
  sudo apt-get install apache2
  ```

- After the completion, enter <http://localhost> or 127.0.0.1 in the browser. If the Apache version page is successfully jumped, the installation is successful.

- Stop the service: 

  ```shell
  sudo /etc/init.d/apache2 stop
  ```

- The default document root directory for Apache is the `/var/www` directory on Ubuntu, the configuration file is `/etc/apache2/apache2.conf`, and the subdirectories stored in the `/etc/apache2` directory are configured.

##### 1.2 PHP(version>=7.0.0 recommend: 7.0.30)

- Install PHP7.0.30：

  ```shell
  sudo apt-get install php7.0.30
  ```

- Install apache2 php7 module：

  ```shell
  sudo apt-get install libapache2-mod-php7.0.30
  ```

- Install MySQL php module：

  ```shell
  apt-get install php5-mysql
  ```

- Create a new file `test.php` in the project root directory. Then input: `echo phpinfo (); `, check whether the environment is configured successfully.

##### 1.3 MySQL(version>=5.7 recommend: 5.7)

- Install mysql-server module：

  ```shell
  sudo apt-get install mysql-server
  ```

- Install mysql_client module：

  ```shell
  sudo apt-get isntall mysql-client
  ```

- Install libmysqlclient-dev module：

  ```shell
  sudo apt-get install libmysqlclient-dev
  ```

- During the installation process, you will be prompted to set a password. Note that you should not forget to set it up. After the installation is complete, you can use the following command to check whether the installation is successful:

  ```shell
  sudo netstat -tap | grep mysql
  ```

  After checking by the above command, if you see that the mysql socket is in the listen state, the installation is successful.

- To log in to the mysql database, you can use the following command:

  ```shell
  mysql -u root -p
  ```

  -u indicates the user name to log in, and -p indicates the user password for login. After the above command is entered, the user will be prompted to enter the password. At this time, the password can be used to log in to mysql.

##### 1.4 MongoDB(recommend: 3.4.9)

- Install MongoDB via apt:

  ```shell
  sudo apt-get install mongo3.4.9
  ```

- Install PHP MongoDB driver

  - First need to install pecl: 

    ```shell
    sudo apt-get install php-pear
    ```

  - Then install the MongoDB extension via pecl: 

    ```shell
    sudo pecl install mongodb
    ```

  - Note: If ` phpize: not found` appears, you need to install php-dev and then do the above:

    ```shell
    sudo apt-get install php-dev
    ```

  - Note: If  `configure: error: Cannot find OpenSSL's libraries`, try installing the following package 4: 

    ```shell
    sudo apt-get install libcurl4-openssl-dev
    ```

  - Then, add `extension=mongodb.so` to `php.ini` file ;

  - Restart Apache2: 

    ```shell
    service restart apache2
    ```

##### 1.5 Composer(recommend: 1.5.2)

- Download:

  ```shell
  curl –sS <https://getcomposer.org/installer> | php
  ```

- Install:

  ```shell
  /usr/bin/php composer.phar –1.5.2
  ```

- Set global command:

  ```shell
  sudo mv composer.phar /usr/local/bin/composer
  ```

  Note: composer is a tool used by PHP to manage dependencies. Composer will help you install php dependent library files in the Laravel framework. The official website is [composer](https://getcomposer.org).

#### 2 Download the code of the web page

Enter the following command at the terminal: 

```shell
git clone https://github.com:/xisiot/lora-web-server
```

 Or download the zip and unzip it to use it.

#### 3 Install the dependencies

Laravel relies on `composer` to install dependencies and use `composer install` to resolve dependencies: (run into the downloaded Laravel project directory):

```shell
composer install
```

#### 4 Add the configuration file

- We need to create the `.env` file, because `.env` file defaults to the files that github ignores: (runs into the downloaded Laravel project directory)

  ```shell
  cp .env.example .env
  ```

- Because there is no app key by default in `env.example `file, we generate a new app key in `.env` file: (run into the downloaded Laravel project directory)

  ```shell
  php artisan key:generate
  ```

- Next, open the `.env` file we just copied and fill in the database information to the appropriate location: mainly the configuration of the MySQL database and the MongoDB database. (The part that needs to be modified is explained in the comments. The default configuration does not need to be modified if there is no demand.)

  ```php
  // the configuration of the database(MySQL)
  DB_CONNECTION=mysql
  // the host of the database
  DB_HOST=127.0.0.1
  // the port of the database
  DB_PORT=3306
  // the name of the database
  DB_DATABASE=
  // the username
  DB_USERNAME=
  // the password
  DB_PASSWORD=
  
  //registration interface provided by lora server,the default is http://localhost:3000
  HTTP_URL=http://localhost:3000
  
  // the configuration of the database(MongoDB) 
  MONGO_HOST=127.0.0.1
  MONGO_PORT=27017
  // the name of the Mongo database
  MONGO_DB=
  ```

#### 5 Set the considering database

Run the artisan command to perform database migration. The configuration information of the database is in the `.env` configuration file above: (Run into the downloaded Laravel project directory)

```shell
php artisan migrate
```

If the operation is successful, the required data table will be created in the set MySQL database.

#### 6 Start-up

##### 6.1 Start-up Directly

- Run the artisan command in the project root directory:

  ```shell
  php artisan serve --host=0.0.0.0 --port=XXXX
  ```

##### 6.2 Ubuntu14.04

- Add the `xxx.conf` file to the `/etc/init `folder and configure the project path, log, startup commands, and so on. (The part that needs to be modified is explained in the comments.The default configuration does not need to be modified if there is no demand.)

  ```shell
  # lora-simple-web config
  # a web management system for lora-simple-web
  # this is a upstart conf file
  # lora-simple-web name can be modified, 
  # this is the name of the self-started service
  description  "lora-simple-web"
  # no configuration required
  start on runlevel [2345]
  stop on shutdown
  	
  respawn
  respawn limit 10 5
  # configuration content that needs to be modified
  script
       PHP=`which php`
       # the directory of the Laravel project
       PROJECT_PATH='/XXX/XXX/lora-simple-web'
       # the directory of the log of the Laravel project
       LOG_PATH='/XX/XX/lora-simple-web/storage/logs/laravel.log'
       # self-starting host name, set to local
       HOST='0.0.0.0'
       # the port number of the web page,
       # ensure that it is not occupied by other services.
       PORT=XXXX
       # no configuration required
       LOG_DIR=`dirname $LOG_PATH`
       [[ -d $LOG_DIR ]] || mkdir -p $LOG_PATH
       # no configuration required
       exec $PHP "$PROJECT_PATH/artisan" serve --host $HOST --port $PORT >> $LOG_PATH 2>&1
  end script
  ```

- Self-starting start/stop/restart

  ```shell
  service xxx start/stop/restart
  ```

  (`XXX` is` lora-simple-web` in this example configuration file)

##### 6.3 Ubuntu16.04

- Add the startup script to the `/usr/sbin/` directory and write the absolute path to the `xxx.service` file in `/lib/systemd/system/`

  ```shell
  #!/bin/sh  XXX stand for the absolute path of the laravel project 
  php /XXX/XXX/lora-simple-web /artisan serve --host 0.0.0.0 --port XXXX
  #the XXXX after the port indicates the port number of the web page startup.
  ```

- Add the `xxx.service` file to `/lib/systemd/system/`

  ```shell
  [Unit]
  Description= lora-simple-web
  
  [Service]
  #Type=forking
  #User=root
  #the specific shell execution file of the service process, 
  #xxx is the file name, not the folder name
  ExecStart=/usr/sbin/lora-simple-web 
  #here is the startup configuration file under the /usr/sbin/ path above.
  PrivateTmp=true
  
  [Install]
  WantedBy=multi-user.target
  ```

- Self-starting start/stop/restart:

  ```shell
  systemctl start/stop/restart xxx.servic
  ```

  

#### 7 The running of the web

Open the local IP + the PORT number in the configuration file in the browser (for example: 127.0.0.1:8888, 8888 is the PORT you set) , and you will see the web.

#### 8 Appendix

- <https://www.cnblogs.com/timmmmit/archive/2017/10/22/7709483.html> 
- http://www.runoob.com/mongodb/mongodb-window-install.html 
- Domestic use of Composer sometimes encounters problems with poor network. It is recommended to use the full-size image recommended by Composer Chinese website http://www.phpcomposer.com/ to synchronize the contents of the Composer repository to the domestic server.

