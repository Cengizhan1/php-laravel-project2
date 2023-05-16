<?php

namespace App\Http\Controllers\AdminApi\Dietician;

use App\Enum\SubscriptionPackageTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Dietician\DetoxCategoryRequest;
use App\Http\Requests\AdminApi\Dietician\DietCategoryIndexRequest;
use App\Http\Resources\AdminApi\Dietician\DetoxCategoryResource;
use App\Http\Resources\User\DietCategoryResource;
use App\Models\Clinic;
use App\Models\DetoxCategory;
use App\Models\DietCategory;
use Illuminate\Http\Request;

class DetoxCategoryController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(DetoxCategory::class, 'detoxCategory');
//        $this->authorizeResource(Clinic::class, 'detoxCategory');
    }

    public function index(DietCategoryIndexRequest $request)
    {
        return DietCategoryResource::collection(get_filtered_data(
            DietCategory::query()->where('type',SubscriptionPackageTypeEnum::detox()->value),$request)->datatable());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetoxCategoryRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $detoxCategory = DietCategory::create([
                'name' => $request->name,
                'type' => SubscriptionPackageTypeEnum::detox()->value,
                'admin_id' => auth()->user()->id,
            ]);
            return response()->success(0, null, $detoxCategory->id, 200);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\DietCategory $dietCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DietCategory $detoxCategory)
    {
        return $this->withErrorHandling(function () use ($detoxCategory) {
            return response()->success(
                data: DetoxCategoryResource::make($detoxCategory)
            );
        });

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DietCategory $dietCategory
     * @return \Illuminate\Http\Response
     */
    public function update(DetoxCategoryRequest $request, DietCategory $detoxCategory)
    {
        return $this->withErrorHandling(function () use ($request, $detoxCategory) {
            $detoxCategory->update([
                'name' => $request->name,
                'type' => SubscriptionPackageTypeEnum::detox()->value,
                'admin_id' => auth()->user()->id,
            ]);
            return response()->success(0, null, $detoxCategory->id, 200);
        });

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DietCategory $dietCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DietCategory $detoxCategory)
    {
        return $this->withErrorHandling(function () use ($detoxCategory) {
            $detoxCategory->diets()->delete();
            $detoxCategory->templateDiets()->delete();
            $detoxCategory->delete();
            return response()->success(0, null, [], 200);
        });
    }
}
