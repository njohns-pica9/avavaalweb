<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 7/28/15
 * Time: 10:57 AM
 */

namespace Avalon\Providers;

use Avalon\Auth\RedisProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Predis\Client;

class AvalonProvider extends ServiceProvider
{
    protected $defer = false;

    public function provides()
    {
        return [
            'Avalon\Auth\RedisProvider',
            'Avalon\Redis\Client'
        ];
    }

    public function boot()
    {
        $this->app['auth']->extend('redis', function(Application $app) {
            return $app->make('Avalon\Auth\RedisProvider');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Avalon\Redis\Client', function(Application $app) {
            $config = $app->make('config')->get('redis');

            $redisClient = new Client($config);
            return new \Avalon\Redis\Client($redisClient);
        });

        $this->app->bind('Avalon\Auth\RedisProvider', function(Application $app) {
            /** @var \Avalon\Redis\Client $client */
            $client = $app->make('Avalon\Redis\Client');
            return new RedisProvider($client);
        });
    }
}