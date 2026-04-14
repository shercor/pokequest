Instrucciones instalación

- Clonar repositorio

- Levantar contenedores:

    * docker compose up -d --build

- Instalar dependencias:

    * docker exec -it laravel_app composer install

- Entrar a contenedor

    * docker compose exec -it laravel_app bash

- Una vez dentro del contenedor, ejecutar los siguientes comandos

    * chmod 777 -R tmp
    * php artisan key:generate
    * php artisan migrate
    * php artisan db:seed
    * php artisan optimize
    * php artisan app:importar_pokemon