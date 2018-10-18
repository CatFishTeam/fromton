# fromton

## Setup project

- Ask a team member for .env content

- Add the following vhost to your machine : `127.0.0.1 dev.fromton.io`

- Run `docker-compose up` to launch project with Docker

- Run `composer install` and `npm install` in /fromton folder

- Go to **dev.fromton.io** (or **dev.fromton.io:your-nginx-port** described in docker-compose file) for the app

## Setup database

- Check that DB exists by logging on Adminer with docker-compose credentials

- Connect to fromton-php container in terminal : `docker exec -ti fromton-php sh`

- Inside php container, create migration files : `bin/console make:migration`

- Run the migrations : `bin/console doctrine:migrations:migrate`


## How to add an image
The images are manage by webpack

 - You'll have to put it in a folder in `assets/images`

 - Then in `app.js` in the section *Images* add : `require('../images/[path-to-image]/image.[ext]')`

 - And ofc run webpack. 
 
 - You'll be able to use it like `<img src="{{ asset('build/images/[path-to-image]/image.[ext]) }}" alt="mouse">`
