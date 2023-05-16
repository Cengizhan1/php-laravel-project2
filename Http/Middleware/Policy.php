<?php

namespace App\Http\Middleware;

use App\Models\Activity;
use App\Models\Client;
use App\Models\Clinic;
use App\Policies\ActivityPolicy;
use ObiPlus\ObiPlus\Http\Middleware\Policy as BasePolicy;

class Policy extends BasePolicy
{
    public function policies(): array
    {
        return [
            'admin' => [
                \App\Models\Activity::class => \App\Policies\ActivityPolicy::class,
                \App\Models\Address::class => \App\Policies\AddressPolicy::class,
                \App\Models\Admin::class => \App\Policies\AdminPolicy::class,
                \App\Models\Allergy::class => \App\Policies\AllergyPolicy::class,
                \App\Models\BeforeAfter::class => \App\Policies\BeforeAfterPolicy::class,

                \App\Models\UserSubscription::class => \App\Policies\UserSubscriptionPolicy::class,
                \App\Models\TemplateDetox::class => \App\Policies\TemplateDetoxPolicy::class,
                \App\Models\TemplateDiet::class => \App\Policies\TemplateDietPolicy::class,
                \App\Models\Diet::class => \App\Policies\DietPolicy::class,


                \App\Models\Calendar::class => \App\Policies\CalendarPolicy::class,
                \App\Models\CallResult::class => \App\Policies\CallResultPolicy::class,
                \App\Models\City::class => \App\Policies\CityPolicy::class,
                \App\Models\Client::class => \App\Policies\AllergyPolicy::class,
                \App\Models\Clinic::class => \App\Policies\ClinicPolicy::class,

                \App\Models\Contact::class => \App\Policies\ContactPolicy::class,
                \App\Models\Country::class => \App\Policies\CountryPolicy::class,
                \App\Models\DailyCaffein::class => \App\Policies\DailyCaffeinPolicy::class,
                \App\Models\DailyWater::class => \App\Policies\DailyWaterPolicy::class,
                \App\Models\Destination::class => \App\Policies\DestinationPolicy::class,

                \App\Models\DetoxCategory::class => \App\Policies\DetoxCategoryPolicy::class,
                \App\Models\DietCategory::class => \App\Policies\DietCategoryPolicy::class,

                \App\Models\Detox::class => \App\Policies\DetoxPolicy::class,
                \App\Models\DietCompatibility::class => \App\Policies\DietCompatibilityPolicy::class,
                \App\Models\Disease::class => \App\Policies\DiseasePolicy::class,
                \App\Models\EatingHabit::class => \App\Policies\EatingHabitPolicy::class,

                \App\Models\MealNutrient::class => \App\Policies\MealNutrientPolicy::class,
                \App\Models\Meal::class => \App\Policies\MealPolicy::class,
                \App\Models\MealTime::class => \App\Policies\MealTimePolicy::class,
                \App\Models\MeetComment::class => \App\Policies\MeetCommentPolicy::class,
                \App\Models\Meet::class => \App\Policies\MeetPolicy::class,

                \App\Models\Nutrient::class => \App\Policies\NutrientPolicy::class,
                \App\Models\Permission::class => \App\Policies\PermissionPolicy::class,
                \App\Models\PhysicalActivity::class => \App\Policies\PhysicalActivityPolicy::class,
                \App\Models\QuickMessage::class => \App\Policies\QuickMessagePolicy::class,
                \App\Models\RecipeCategory::class => \App\Policies\RecipeCategoryPolicy::class,

                \App\Models\Recipe::class => \App\Policies\RecipePolicy::class,
                \App\Models\Report::class => \App\Policies\ReportPolicy::class,
                \App\Models\SleepPattern::class => \App\Policies\SleepPatternPolicy::class,
                \App\Models\SubscriptionComment::class => \App\Policies\SubscriptionCommentPolicy::class,
                \App\Models\UserWaterConsumption::class => \App\Policies\UserWaterConsumptionPolicy::class,
            ],
            'customer' => [

            ],
            'client' => [

            ],
        ];
    }
}
