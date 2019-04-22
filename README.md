# Baby memo - Easy record your baby activities

### Architecture

* Backend: CakePHP3.7
* Frontend: Nuxt2

### Main branches

| #   | Branch | Description |
| --- | --- | --- |
| 1   | master | Contain source code to be pushed to production server |
| 2   | dev | Contain merged source code of below `dev-backend` and `dev-frontend` branches to be pushed to test server |
| 3   | dev-backend | Contain development source code of backend module |
| 4   | dev-frontend | Contain development source code of frontend module |
| 5   | deploy | Contain deployment script |

### Installation

1. Clone repository

1. Create empty database with name `cabo` and `cabo-test`

1. Configuration backend

    Copy `/{path-to-source}/backend/config/.env.default` to `/{path-to-source}/backend/config/.env` and edit value in it if neccessary.

1. Install backend dependencies:

    ~~~
    $ cd /{path-to-source}/backend
    $ composer install
    ~~~

1. Install frontend dependencies:

    ~~~
    $ cd /{path-to-source}/frontend
    $ npm install
    ~~~

