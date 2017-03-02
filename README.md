# spatter
Spatter is a SPA super basic version of Twitter built on Silex, with the lightest sprinkling of Vue.js (10 whole lines!?!).

# Building Spatter yourself is 6 super easy steps!

0. Have PHP 5.6 installed (it might work on PHP 7 but thats not a guarentee!)

1. Clone this repository
2. Create a MySQL schema named spatter and set your database username/password to any account you want that has full access
3. Run composer install
4. Run vendor/bin/doctrine orm:schema-tool:create
5. Run composer dump-autoload -o
6. Run php -S localhost:8888 -t public
7. Start Spatting!

