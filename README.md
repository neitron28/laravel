## Create Laravel project
docker-compose exec app composer create-project --prefer-dist laravel/laravel .

## Authentication
docker-compose exec app composer require laravel/jetstream
docker-compose exec app php artisan jetstream:install livewire
docker-compose exec app php artisan migrate
docker-compose exec app npm install && npm run dev