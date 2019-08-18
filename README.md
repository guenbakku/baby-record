# baby-record - Deploy script

## Installation

1. Pull source code from `origin` to new folder and checkout to branch `deploy`.

1. Copy private key `ec2-virginia-ec2-user.pem` (which is used to connect to web server) to directory `docker/php` in source code.

1. Build docker image
    ```
    $ docker-compose build
    ```

1. Install composer libraries
    ```
    $ docker-compose run --rm php composer install
    ```

## Deployment

1. Start docker service and SSH into it
    ```
    $ docker-compose up -d
    $ docker-compose exec php /bin/bash
    ```

1. Execute one of below commands

    ``` bash
    $ vendor/bin/dep deploy {stage or hostname} --branch {branch-name}

    # or
    $ vendor/bin/dep deploy {stage or hostname} --tag {tag-name}

    # or
    $ vendor/bin/dep deploy {stage or hostname} --revision {revision-hash}
    ```

    Example:

    ```
    $ vendor/bin/dep deploy dev --branch dev
    ```

    [Click here](https://deployer.org/docs) for more info about Deployer.
