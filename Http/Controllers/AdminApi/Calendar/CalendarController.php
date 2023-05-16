<?php

namespace App\Http\Controllers\AdminApi\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meet;
use App\Models\Detox;
use App\Models\Diet;
use Carbon\Carbon;

use App\Http\Resources\User\Calendar\UserMeetResource;

class CalendarController extends Controller
{
    public function index()
    {
        return $this->withErrorHandling(function () {
        
            return collect([
                'totalMeets' => Meet::count(),
                'detoxes' => Meet::where('status', 2)->count(),
                'diets' => Meet::where('status', 1)->count(),
                'faceToFaceDiets' => Meet::where('status', 3)->where('is_face_2_face', 0)->count(),
            ]);
            
        });
    }
    public function pastMeets()
    {
        return $this->withErrorHandling(function () {
        
            return collect([
                'totalMeets' => Meet::whereDate('start_at','<',now())->count(),
                'detoxes' => Meet::where('status', 2)->whereDate('date','<',now())->count(),
                'diets' => Meet::where('status', 1)->whereDate('date','<',now())->count(),
                'faceToFaceDiets' => Meet::where('status', 0)->whereDate('date','<',now())->where('is_face_2_face', 0)->count(),
            ]);
            
        });
    }
    public function currentMeet()
    {
        return $this->withErrorHandling(function () {
        
            return collect([
                'totalMeets' => Meet::whereDate('start_at', Carbon::now())->count(),
                'detoxes' => Meet::where('status', 2)->whereDate('date', Carbon::now())->count(),
                'diets' => Meet::where('status', 1)->whereDate('date', Carbon::now())->count(),
                'faceToFaceDiets' => Meet::where('status', 0)->whereDate('date', Carbon::now())->where('is_face_2_face', 0)->count(),
            ]);
            
        });
    }

}
