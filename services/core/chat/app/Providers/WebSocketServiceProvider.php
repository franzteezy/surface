<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;
use Ratchet\Server\IoServer;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\SocketController;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require dirname(__DIR__) . '/../vendor/autoload.php';
class WebSocketClass {

    public function establishServer(){
        return IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketController()
                )
            ),
            3000
        );
    }
}
class WebSocketServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('wsserver', function () {
            return new WebSocketClass;
        });
        //
    }
}
class WebSocket extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'wsserver';
    }
}
