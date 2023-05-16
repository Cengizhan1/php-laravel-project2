<?php

namespace App\Jobs;

use App\Models\UserMeasurement;
use App\Models\UserSubscriptionSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReportCard implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle()
    {
        // TODO günlük olarak ölçümlerin kaydedilmesi gerekli
        foreach (UserSubscriptionSession::whereHas('meet',function ($query){
            $query->where('start_at','>',now()->addDay(1));
        })->get() as $session) {
            $report = $session->weeklyReport()->first();
            $measurement = UserMeasurement::where('user_subscription_session_id',$session->id)->first();
            if (!$report->date){
                $report->update([
                    'total_fat_rate_change'=>0,
                    'weight_change'=>$measurement->weight,
                    'water_consumption'=>1,
                    'report_id'=>$report->id,
                    'session_id'=>$session->id,
                    'date'=>now(),
                ]);
            }
        }
    }
}
