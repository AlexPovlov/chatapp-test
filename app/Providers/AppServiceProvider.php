<?php

namespace App\Providers;

use App\Services\ChatappApi;
use App\Services\Interfaces\ChatappApiInterface;
use App\Services\Interfaces\MailingJobServiceInterface;
use App\Services\Interfaces\MailingServiceInterface;
use App\Services\MailingJobService;
use App\Services\MailingService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        MailingServiceInterface::class => MailingService::class,
        MailingJobServiceInterface::class => MailingJobService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ChatappApiInterface::class, function ($app) {
            return new ChatappApi(
                new Client(['base_uri' => config('services.chatapp.url')])
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
