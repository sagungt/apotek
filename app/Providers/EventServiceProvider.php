<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $threeMonthFromNow = Carbon::now()->addMonths(3);
            $role = auth()->user()->role;
            switch ($role) {
                case 2:
                    $almostExpired = DB::table('persediaan_obat')
                        ->whereDate('no_exp', '>=', Carbon::now())
                        ->whereDate('no_exp', '<=', $threeMonthFromNow)
                        ->count();
                    break;
                
                default:
                    $almostExpired = DB::table('persediaan_obat')
                        ->where('status', '=', 'Almost Expired')
                        ->count();
                    break;
            }
            $event->menu->addAfter('home', [
                'text' => 'Expiry',
                'url' => 'stock/expiry',
                'can' => ['apoteker', 'gudang'],
                'label' => $almostExpired,
                'icon' => 'fas fa-hourglass-half'
            ]);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
