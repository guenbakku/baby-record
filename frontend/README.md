# baby-record/frontend

> Easy record your baby activities

## Installation

1. Clone source code from git and change to root path.

1. Build docker image
    ``` bash
    $ docker-compose build
    ```

1. Install node_modules
    ``` bash
    $ docker-compose run --rm nuxt npm install
    ```

## How to develop

1. Start docker service
    ``` bash
    $ docker-compose up
    ```

1. Edit source code on your local machine and access to http://localhost:4000 to check the update.

## Build Setup

``` bash
# build for production and launch server
$ npm run build
$ npm start

# generate static project
$ npm run generate
```

For detailed explanation on how things work, checkout [Nuxt.js docs](https://nuxtjs.org).
