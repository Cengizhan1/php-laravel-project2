<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use ObiPlus\ObiPlus\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TourNotification;
use App\Models\User;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () { // diyeti değişimi yaklaşanlara ve measurementini girmeyenlere bildirim
            $users = User::all();
                    foreach($users as $user){
                        Notification::send($user::permission()->where('app_notification', true)
                    ->whereBetween('start_at', [Carbon::now()->subDays(3), Carbon::now()->subDays(2)])->get(),
                    new TourNotification('RO ME','Bitime 3 gün kalmıştır.'));
                    }

        })->daily();

        $schedule->call(function () { //measurementini girmeyenlere bildirim
            $users = User::all();

            foreach($users as $user){
                if(!$user->measurements){
                    Notification::send($user,
                    new TourNotification('RO ME','Ölçümlerinizi girin.'));
                }
            }

        })->daily();

        $schedule->call(function () {
            $users = User::all();
            foreach($users as $user){
                if(Carbon::now()-> diffInDays($user->activeSubscription()->end_at, false) < 10){
                    Notification::send($user,
                    new TourNotification('RO ME','Paketinizin bitimine az kaldı.'));
                }
            }

        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
