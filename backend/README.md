# baby-record/backend

> Easy record your baby activities

## Installation

1. Clone source code from git and change to root path.

1. Build docker image
    ``` bash
    $ docker-compose build
    ```

1. Start docker services
    ``` bash
    $ docker-compose up -d
    ```

1. Access to phpMyAdmin via http://localhost:4040 and create following 2 databases:
    * `baby-record`
    * `baby-record-test`

1. SSH to `php` service, and execute following commands
    ``` bash
    $ docker-compose exec php /bin/bash

    # Install composer libraries
    > composer install

    # Execute database migration
    > bin/cake migrations migrate
    > bin/cake migrations seed

    # Exit SSH
    > exit
    ```

## How to develop

1. Start docker service
    ``` bash
    $ docker-compose up -d
    ```

1. Edit source code on your local machine and access to http://localhost:8080 to check the update.
