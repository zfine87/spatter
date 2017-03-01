<?php namespace App;

use App\Subscriber\TimestampSubscriber;
use Silex;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\ORM\Events;
use Silex\Provider\FormServiceProvider;

class Application extends Silex\Application {

    /**
     * Application Constructor
     */
    function __construct(){
        parent::__construct();
        $this['debug'] = true;
        $this->registerProviders();
        $this->mountControllers();
    }

    /**
     * Register all service providers for the application
     */
    function registerProviders(){

        //Register database service providers
        $this->register(new Silex\Provider\DoctrineServiceProvider(), array(
            'db.options' => array(
                'dbname' => 'spatter',
                'user' => 'root',
                'password' => 'Samps0n1$',
                'host' => 'localhost',
                'port' => '3306',
                'driver' => 'pdo_mysql',
            ),
        ));

        $this->register(new DoctrineOrmServiceProvider, array(
            'orm.em.options' => array(
                'mappings' => array(
                    // Using actual filesystem paths
                    array(
                        'type' => 'annotation',
                        'namespace' => 'App\Models',
                        'path' => __DIR__.'/Models',
                        'use_simple_annotation_reader' => true
                    )
                ),
            )
        ));

        $this['db.event_manager']->addEventSubscriber(new TimestampSubscriber());

        //Register general use service providers
        $this->register(new Silex\Provider\LocaleServiceProvider());
        $this->register(new Silex\Provider\ValidatorServiceProvider());
        $this->register(new Silex\Provider\TranslationServiceProvider(), array(
            'translator.domains' => array(),
        ));
        $this->register(new FormServiceProvider());
        $this->register(new Silex\Provider\SessionServiceProvider());


        //Register security provider and extras
        $this['app.token_authenticator'] = function ($this) {
            return new Security\TokenAuthenticator($this['security.encoder_factory']);
        };
        $this->register(new Silex\Provider\SecurityServiceProvider());
        $this->register(new Silex\Provider\RememberMeServiceProvider());

        //Whole site is behind user auth wall except login and register
        $this['security.firewalls'] = array(
            'login' => [
                'pattern' => '^/auth/login$',
                'anonymous' => true
            ],
            'register' => [
                'pattern' => '^/auth/register$',
                'anonymous' => true
            ],
            'main' => [
                'pattern' => '^/',
                'form'    => ['login_path' => '/auth/login', 'check_path' => '/users/login'],
                'logout'  => ['logout_path' => '/users/logout', 'target_url' => '/'],
                'users'   => function () {
                    return new Providers\UserProvider($this['orm.em']);
                },
                'remember_me' => array(
                    'key'                => 'zWmslk4Zv00rDIVv',
                    'always_remember_me' => true
                )
            ]
        );

        //Encode user passwords with Bcrypt
        $this['security.password_encoder'] = function ($this) {
            return $this['security.encoder.bcrypt'];
        };

        //Register Twig view folder/provider
        $this->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/../public/views',
        ));

    }

    /**
     * Mount Application Controllers
     */
    function mountControllers(){
        $this->mount('/',   new Controller\Provider\Page());
        $this->mount('/auth', new Controller\Provider\Auth());
        $this->mount('/post', new Controller\Provider\Post());
        $this->mount('/users', new Controller\Provider\User());
    }
}