# spatter
Spatter is a SPA super basic version of Twitter built on Silex, with the lightest sprinkling of Vue.js (10 whole lines!?!).
Why start spatting? It's a nice foundation to do other cool things, like show-off a slick UI (Spatter uses BootStrap 4), or extend it to make the next Twitter.

# Building Spatter yourself is super easy!

0. Have PHP 5.6 installed (it might work on PHP 7 but thats not a guarentee!) and also have Composer

1. Clone this repository
2. Create a MySQL schema named spatter and set your database username/password to any account you want that has full access
3. Run `composer install`
4. Run `composer update`
5. Run `vendor/bin/doctrine orm:schema-tool:create`
6. Run `composer dump-autoload -o`
7. Run `php -S localhost:8888 -t public`

Go to localhost:8888 and start spatting!



