<?php namespace AppBundle;

use AppBundle\Subscriber\TimestampSubscriber;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Yaml\Yaml;

class Application extends Silex\Application {

    /**
     * Application Constructor
     */
    function __construct(){
        parent::__construct();

        //If this ever goes to production turn this off!
        $this['debug'] = true;

        $this->registerProviders();
        $this->mountControllers();
    }

    /**
     * Register all service providers for the application
     */
    function registerProviders(){

        //Monologger
        $this->register(new Silex\Provider\MonologServiceProvider(), [
            'monolog.logfile' => __DIR__.'../../../var/Logs/development.log',
        ]);

        //Register database service providers
        $this->register(new Silex\Provider\DoctrineServiceProvider(), [
            'db.options' =>  Yaml::parse(
                file_get_contents(__DIR__.'../Config/database.yml')
            )
        ]);

        //Add event subscriber for automatic timestamp creation
        $this['db.event_manager']->addEventSubscriber(new TimestampSubscriber());

        //Add orm layer on top of doctrine
        $this->register(new DoctrineOrmServiceProvider, [
            'orm.em.options' => [
                'mappings' => [
                    // Using actual filesystem paths
                    [
                        'type' => 'annotation',
                        'namespace' => 'AppBundle\Models',
                        'path' => __DIR__.'/Models',
                        'use_simple_annotation_reader' => true
                    ]
                ],
            ]
        ]);


        //Register general use service providers
        $this->register(new Silex\Provider\CsrfServiceProvider());
        $this->register(new Silex\Provider\LocaleServiceProvider());
        $this->register(new Silex\Provider\ValidatorServiceProvider());
        $this->register(new Silex\Provider\TranslationServiceProvider(), [
            'translator.domains' => [],
        ]);
        $this->register(new FormServiceProvider());


        $this->register(new Silex\Provider\SessionServiceProvider(), [
            //Check if in test mode for PHPUnit
            'session.test' => getenv('env') ? true : false
        ]);

        //Register security provider and extras
        $this->register(new Silex\Provider\SecurityServiceProvider());
        $this->register(new Silex\Provider\RememberMeServiceProvider());
        $this['security.password_encoder'] = function ($this) {
            return $this['security.encoder.bcrypt'];
        };

        //Register custom user login authenticator
        $this['app.login_authenticator'] = function ($this) {
            return new Security\LoginAuthenticator($this['security.encoder_factory']);
        };


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
                'form'    => ['login_path' => '/auth/login', 'check_path' => '/users/login', 'default_target_path' => '/', 'always_use_default_target_path' => true],
                'logout'  => ['logout_path' => '/users/logout', 'target_url' => '/auth/login'],
                'users'   => function () {
                    //Very important that users are passed ORM connection and not standard DB connection
                    return new Providers\UserProvider($this['orm.em']);
                },
                'guard' => [
                    'authenticators' => [
                        'app.login_authenticator'
                    ]
                ],
                'remember_me' => [
                    'key'                => 'zWmslk4Zv00rDIVv',
                    'always_remember_me' => true
                ]
            ]
        );

        //Register Twig view folder/provider
        $this->register(new Silex\Provider\TwigServiceProvider(), [
            'twig.path' => __DIR__.'/../../app/Resources/views',
        ]);
    }

    /**
     * Mount Application Controllers
     */
    function mountControllers(){
        $this->mount('/',   new Controller\Provider\Page());
        $this->mount('/auth', new Controller\Provider\Auth());
        $this->mount('/post', new Controller\Provider\Post());

        //There is a users controller but it doesn't have a purpose yet, just uncomment to enable it
        //$this->mount('/users', new Controller\Provider\User());
    }
}