# Laravel Blog Feed Reader
Give a tool that can read a feed or rss, user can register it and bookmark articles to read late. It's also implement cache that help a lot of processing and performance. You can modify time cache at config/blog_feed.php
## Requirement
- MySQL
- PHP
- APACHE/NGINX
- composer

## Install
### Install requirements
```
composer install
php artisan key:generator
php artisan migrate
```
### Setup Database
1. Create database
2. Paste database name at .env file
3. add this line into app, into services array
```
App\Providers\RssReaderServiceProvider::class,
```

### Working GUI
1. You can register user and Try
### Working Console
1. list all feed register, default user id = 1. user can modify it at file config
```
php artisan feed:list
```
2. Read current feed
```
php artisan feed:read {id} # id of feed or url
```
3. Add new feed
```
php artisan feed:add {url} --title # id of feed or url
```
4. Remove new feed
```
php artisan feed:remove {id} # id of feed or url
```