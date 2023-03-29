<?php

namespace App\Providers;

use App\Events\NewStoreRequestRegistration;
use App\Listeners\TriggerNewStoreRequestRegistration;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\NewNotificationFromAdminEvent;
use App\Listeners\TriggerForNewNotificationFromAdminListener;

use App\Events\NewEmailMagazineEvent;
use App\Listeners\TriggerForNewEmailMagazineListener;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewNotificationFromAdminEvent::class =>[
            TriggerForNewNotificationFromAdminListener::class
        ],
        NewEmailMagazineEvent::class =>[
            TriggerForNewEmailMagazineListener::class
        ],
        NewStoreRequestRegistration::class =>[
            TriggerNewStoreRequestRegistration::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
