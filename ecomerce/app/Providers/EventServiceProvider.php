<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Order;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //cuando se crea un objeto del Modelo Order se ejecuta la función
        Order::created(function($order){
            $order->sendMail();
        });

        //cuando se actualize algo del modelo Order
        Order::updated(function($order){
            $order->sendUpdateMail();
        });
    }
}
