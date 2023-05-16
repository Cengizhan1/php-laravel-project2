<?php

use App\Models\Nutrient;
use App\Models\User;
use Carbon\Carbon;

if (!function_exists('get_formatted_date')) {
    function get_formatted_date($date)
    {
        $formattedDate = date_create($date);
        return date_format($formattedDate, "j-n-Y");
    }
}
if (!function_exists('get_formatted_date_time')) {
    function get_formatted_date_time($date)
    {
        $formattedDate = date_create($date);
        return date_format($formattedDate, "j-n-Y H:i");
    }
}
if (!function_exists('get_group_id')) {
    function get_group_id($array)
    {
        if (!$array) {
            return null;
        }
        $group_id = null;

        foreach ($array as $item) {
            $id = Nutrient::find((integer)$item)->alternative_group_id;
            if ($id != null) {
                $group_id = $id;
            }
        }
        foreach ($array as $item) {
            Nutrient::find($item)->update([
                'alternative_group_id' => (integer)($group_id ?? Nutrient::max('alternative_group_id')) + 1
            ]);
        }
        return (integer)($group_id ?? Nutrient::max('alternative_group_id')) + 1;
    }
}

if (!function_exists('get_meet_by_time')) {
    function get_meet_by_time($model, $request)
    {
        $model = $model->when(
            $request->has('filter_date'), function ($query) use ($request) {
            $query->where('start_at', '>=', date($request->filter_date));
        });

        return $model;
    }
}

if (!function_exists('check_available_nutrient_for_user')) {
    function check_available_nutrient_for_user($nutrient, $user)
    {

    }
}

if (!function_exists('get_filtered_data')) {
    function get_filtered_data($model, $request)
    {
        $model = $model->when(
            $request->has('search'),
            function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery
                        ->where('id', 'ilike', '%' . $request->search . '%')
                        ->orWhere('name', 'ilike', '%' . $request->search . '%')
                        ->orWhere('date', 'ilike', '%' . $request->search . '%');
                });
            });
        $language = config('app.locale');
        $model = $model->when(
            $request->has('sortBy'),
            function ($query) use ($language, $request) {
                if ($request->sortBy == 'name') {
                    $query->orderBy($request->sortBy . '->' . $language, $request->sortByDirection ?? 'ASC');
                } else {
                    $query->orderBy($request->sortBy, $request->sortByDirection ?? 'ASC');
                }
            });
        $model = $model->when(
            $request->has('admin_id'), function ($query) use ($request) {
            $query->whereIn('admin_id', $request->admin_id);
        });
        $model = $model->when(
            $request->has('calorie_max'), function ($query) use ($request) {
            $query->where('calorie', '<=', $request->get('calorie_max'));
        });
        $model = $model->when(
            $request->has('unit'), function ($query) use ($request) {
            $query->where('unit', $request->get('unit'));
        });
        $model = $model->when(
            $request->has('calorie_min'), function ($query) use ($request) {
            $query->where('calorie', '>=', $request->get('calorie_min'));
        });

        $model = $model->when(
            $request->has('start_at'), function ($query) use ($request) {
            $query->where('date', ">=", date($request->start_at));
        });
        $model = $model->when(
            $request->has('end_at'), function ($query) use ($request) {
            $query->where('date', "<=", date($request->end_at));
        });

        $model = $model->when(
            $request->has('category'), function ($query) use ($request) {
            $query->where('diet_category_id', $request->category);
        });


        return $model;
    }
}

if (!function_exists('get_filtered_user')) {
    function get_filtered_user($model, $request)
    {
        $model = $model->when(
            $request->has('search'),
            function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->where('id', 'ilike', '%' . $request->search . '%')
                        ->orWhereRaw("concat(first_name, ' ', last_name) ilike ?", ["%$request->search%"])
                        ->orWhere('email', 'ilike', '%' . $request->search . '%')
                        ->orWhere('phone', 'ilike', '%' . $request->search . '%');
                });

            });

        $model = $model->when(
            $request->has('sortBy'),
            function ($query) use ($request) {
                $query->orderBy($request->sortBy, $request->sortByDirection ?? 'ASC');
            });

        $model = $model->when(
            $request->has('country_id'),
            function ($query) use ($request) {
                $query->whereHas('addresses', function ($relationQuery) use ($request) {
                    $relationQuery->whereHas('city', function ($subRelationQuery) use ($request) {
                        return $subRelationQuery->where('country_id', $request->country_id);
                    });
                });
            });
        $model = $model->when(
            $request->has('role_id'),
            function ($query) use ($request) {
                $query->whereHas('role', function ($relationQuery) use ($request) {
                    return $relationQuery->where('role_id', $request->role_id);

                });
            });
        $model = $model->when(
            $request->has('city_id'),
            function ($query) use ($request) {
                $query->whereHas('addresses', function ($relationQuery) use ($request) {
                    return $relationQuery->where('city_id', $request->city_id);
                });
            });
        $model = $model->when(
            $request->has('start_at'), function ($query) use ($request) {
            $query->where('date', ">=", $request->start_at);
        });
        $model = $model->when(
            $request->has('end_at'), function ($query) use ($request) {
            $query->where('date', "=<", $request->end_at);
        });
        $model = $model->when(
            $request->has('package_type'), function ($query) use ($request) {
            $query->whereHas('subscriptions', function ($relationQuery) use ($request) {
                return $relationQuery->where('status', 0)->where('subscription_category',$request->package_type);
            });
        });
        $model = $model->when(
            $request->has('payment_method'), function ($query) use ($request) {
            $query->where('payment_method', $request->payment_method);
        });
        $model = $model->when(
            $request->has('status'), function ($query) use ($request) {
            $query->where('status', $request->status);
        });
        $model = $model->when(
            $request->has('is_new_customer'), function ($query) use ($request) {
            $query->where('created_at','>=', now()->subDay(7));
        });
        $model = $model->when(
            $request->has('is_regular_customers'), function ($query) use ($request) {
            $query->where('created_at','<', now()->subDay(7));
        });
        $model = $model->when(
            $request->has('is_requesting_calorie_information'), function ($query) use ($request) {
            $query->where('can_see_calorie','<',$request->is_those_who_no_not_continue);
        });
        $model = $model->when(
            $request->has('is_requesting_diet_list_comparison'), function ($query) use ($request) {
            $query->where('can_compare_diets','<',$request->is_requesting_diet_list_comparison);
        });
        $model = $model->when(
            $request->has('is_those_who_no_not_continue'), function ($query) use ($request) {
            $query->where('is_those_who_no_not_continue','<',$request->is_those_who_no_not_continue);
        });
        $userIds = array();
        $userIdsIn = array();
        if ($request->has('active_package')){
            foreach (User::all() as $user){
                if (!$user->activeSubscription()){
                    $userIdsIn[] = $user->id;
                }
            }
        }
        if ($request->has('is_no_active_package')){
            foreach (User::all() as $user){
                if (!$user->activeSubscription()){
                    $userIds[] = $user->id;
                }
            }
        }
        if ($request->has('is_waiting_action')){
            foreach (User::all() as $user){
                if ($user->activeSubscription()?->sessions?->whereNull('meet_id')->count()){
                    $userIds[] = $user->id;
                }
            }
        }
        if (count($userIds)){
            $model = $model->whereNotIn('id',$userIds);
        }
        if (count($userIdsIn)){
            $model = $model->whereIn('id',$userIdsIn);
        }

        $model = $model->when(
            $request->has('call_result_status'),
            function ($query) use ($request) {
                $query->whereHas('callResult', function ($relationQuery) use ($request) {
                    return $relationQuery->where('call_result_state', $request->call_result_status);
                });
            });
        $model = $model->when(
            $request->has('not_contacted'),
            function ($query) use ($request) {
                $query->whereDoesntHave('callResult');
            });

        $model = $model->when(
            $request->has('photo_share_permission'), function ($query) use ($request) {
            $query->where('photo_share_permission',$request->photo_share_permission);
        });

        return $model;
    }

}

if (!function_exists('get_time_diff')) {
    function get_time_diff($start_at)
    {
        $start = now();
        $end = $start_at;
        $diff = $start->diff($end);
        if ($diff->y != 0) {
            return (string)(__('general.ago.day', ['date' => $diff->y]));
        } elseif ($diff->m != 0) {
            return (string)(__('general.ago.month', ['date' => $diff->m]));
        } elseif ($diff->d != 0) {
            return (string)(__('general.ago.year', ['date' => $diff->d]));
        } else return null;
    }
}
if (!function_exists('re_date_meet')) {
    function re_date_meet($date, $availableDays)
    {
        $newDate = \Carbon\Carbon::parse($date)->addDay(1);
        if (!in_array($newDate->dayOfWeek, $availableDays)) {
            re_date_meet($newDate, $availableDays);
        }
        return $newDate;
    }
}

if (!function_exists('re_assign_nutrient')) {
    function re_assign_nutrient($nutrient, $user)
    {
        if (count(array_intersect($nutrient->alergies_nutrients->pluck('id')->toArray(), $user->allergies->pluck('id')->toArray()))) {
            return false;
        }
        if (count(array_intersect($nutrient->disease->pluck('id')->toArray(), $user->diseases->pluck('id')->toArray()))) {
            return false;
        }
        if ($nutrient->vegan != $user->vegan) {
            return false;
        }
        if ($nutrient->vegetarian != $user->vegetarian) {
            return false;
        }
        if (!$nutrient->pregnant && $user->pregnant) {
            return false;
        }
        if (!$nutrient->suckle && $user->suckle) {
            return false;
        }
        return $nutrient;
    }
}
if (!function_exists('get_alternative_nutrient')) {
    function get_alternative_nutrient($nutrient, $user)
    {
        $alternativeNutrient = null;
        $result = re_assign_nutrient($nutrient, $user);
        if (!$result) {

            foreach (Nutrient::where('alternative_group_id', $nutrient->id)->get() as $alternative) {
                $resultAlternative = re_assign_nutrient($alternative, $user);
                if ($resultAlternative != false) {
                    $alternativeNutrient = $alternative;
                    break;
                }
            }
        }
        return $result == false ? $alternativeNutrient : $nutrient;
    }
}

