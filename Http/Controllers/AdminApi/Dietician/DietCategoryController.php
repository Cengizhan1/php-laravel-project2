<?php

namespace App\Http\Controllers\AdminApi\Dietician;

use App\Enum\SubscriptionPackageTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Dietician\DietCategoryRequest;
use App\Http\Requests\AdminApi\Dietician\DietCategoryIndexRequest;
use App\Http\Resources\AdminApi\Dietician\DetoxCategoryResource;
use App\Http\Resources\User\DietCategoryResource;
use App\Models\DetoxCategory;
use App\Models\DietCategory;
use Illuminate\Http\Request;

class DietCategoryController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(DietCategory::class, 'dietCategory');
    }


    public function index(DietCategoryIndexRequest $request)
    {

        return DietCategoryResource::collection(get_filtered_data(
            DietCategory::query()->where('type',SubscriptionPackageTypeEnum::diet()->value),$request)->datatable());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DietCategoryRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $dietCategory = DietCategory::create([
                'admin_id' => auth()->user()->id,
                'type' => SubscriptionPackageTypeEnum::diet()->value,
                'name' => $request->name,
            ]);
            return response()->success(0, null, $dietCategory->id, 201);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\DietCategory $dietCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DietCategory $dietCategory)
    {
        return $this->withErrorHandling(function () use ($dietCategory) {
            return response()->success(
                data: DietCategoryResource::make($dietCategory)
            );
        });

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DietCategory  $dietCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DietCategory $dietCategory)
    {
        return $this->withErrorHandling(function () use ($request,$dietCategory) {
            $dietCategory->update([
                'name' => $request->name,
                'type' => SubscriptionPackageTypeEnum::diet()->value,
                'admin_id' => auth()->user()->id,
            ]);
            return response()->success(0, null,  $dietCategory->id, 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DietCategory  $dietCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DietCategory $dietCategory)
    {
        return $this->withErrorHandling(function () use ($dietCategory) {
            $dietCategory->diets()->delete();
            $dietCategory->templateDiets()->delete();
            $dietCategory->delete();
            return response()->success(0, null, [], 201);
        });
    }
}
