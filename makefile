start:
	php artisan serve
	npm run watch

deploy-test:
	git pull
	cp .env.test-server .env
	composer install
	rm -rf node_modules
	npm install
	php artisan migrate
	php artisan db:seed
	php artisan storage:link

deploy-production:
	git pull
	cp .env.production-server .env
	composer install
	rm -rf node_modules
	npm install
	php artisan migrate
	php artisan db:seed
	php artisan storage:link

init-app:
	composer install
	rm -rf node_modules
	npm install
	php artisan key:generate
	php artisan migrate
	php artisan db:seed
	php artisan storage:link

route:
	php artisan route:list

cache:
	php artisan cache:clear && php artisan view:clear

autoload:
	composer dump-autoload

build:
	npm run dev

watch:
	npm run watch