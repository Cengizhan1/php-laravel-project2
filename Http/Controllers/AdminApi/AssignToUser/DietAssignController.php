<?php

namespace App\Http\Controllers\AdminApi\AssignToUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\AssignToUser\DietAssignStoreRequest;
use App\Http\Requests\AdminApi\AssignToUser\DietAssignEditRequest;
use App\Http\Requests\AdminApi\Calendar\MeetUpdateRequest;

use Illuminate\Support\Facades\Notification;
use App\Notifications\TourNotification;

use App\Models\Diet;
use App\Models\Meal;
use App\Models\Meet;
use App\Models\Nutrient;
use App\Models\TemplateDiet;
use App\Models\User;

class DietAssignController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Meal::class);
//        $this->authorizeResource(User::class);
//        $this->authorizeResource(TemplateDiet::class);
//        $this->authorizeResource(Diet::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DietAssignStoreRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $user = User::find($request->user_id);
            $diet = Diet::create([
                'name' => $request->name,
                'admin_id' => auth()->user()->id,
                'date' => now(),
                'diet_category_id' => $request->diet_category_id,
                'package_type' => $request->package_type,
                'user_id' => $request->user_id,
                'message' => $request->message,
                'status' => $request->status,
                'user_subscription_id' => $user->subscriptions()->where('status', 0)->first()->id,
                'is_face_2_face' => $request->is_face_2_face,
            ]);

            foreach ($request->meals as $meal) {
                $tempMeal = $diet->meals()->create([
                    'start_at' => $meal['start_at'],
                    'end_at' => $meal['end_at'],
                    'meal_time_id' => $meal['meal_time_id'],
                ]);
                $tempMeal->nutrients()->attach($meal['nutrients']);
            }
            Notification::send($user, new TourNotification('RO ME','Ölçümlerinizi girin.'));
            return response()->success(0, null, $diet->id, 201);
        });
    }

    public function edit(DietAssignEditRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $user = User::find($request->user_id);
            $diet = TemplateDiet::find($request->template_diet_id);
            $newDiet = $diet;
            foreach ($newDiet->meals as $meal) {
                $nutrients = $meal->nutrients;
                $meal->nutrients()->detach();
                foreach ($nutrients as $nutrient) {
                    $result = get_alternative_nutrient($nutrient, $user);
                    $meal->nutrients()->attach($result?->id);
//                    $generatedNutrients[] = collect([
//                        'meal_id' => $nutrient,
//                        'old_nutrient' => $nutrient,
//                        'new_nutrient' => $result,
//                        'is_changed' => $result->id != $nutrient->id,
//                    ]);
                }
            }
            return response()->success(0, null, $newDiet, 201);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Meet $meet
     * @return \Illuminate\Http\Response
     */
    public function meetsUpdate(MeetUpdateRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {

            return response()->success(0, null, [], 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Meet $meet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meet $meet)
    {
        return $this->withErrorHandling(function () use ($meet) {
            $meet->delete();
            return response()->success(0, null, $meet->id, 201);
        });
    }
}
