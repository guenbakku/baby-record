# baby-record - Deploy script

## Installation

1. Pull source code from `origin` to new folder and checkout to branch `deploy`.

1. Connect to virtual machine via SSH

    1. Composer installation

        ```
        $ cd /path/to/deploy
        $ composer install
        ```

    1. Copy private key of web server to virtual machine and set correct permission

        ```
        $ mkdir ~/.ssh/private_keys
        $ chmod 700 ~/.ssh/private_keys
        $ cp /path/to/private_key.pem ~/.ssh/private_keys/
        $ chmod 400 ~/.ssh/private_keys/private_key.pem
        ```

## Deployment

Connect to virtual machine via SSH

1. Go to deploy script folder

    ```
    $ cd /path/to/deploy
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
