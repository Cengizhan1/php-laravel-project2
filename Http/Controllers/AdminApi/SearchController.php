<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

use App\Models\Activity;
use App\Models\Allergy;
use App\Models\CallResult;
use App\Models\Clinic;
use App\Models\Contact;
use App\Models\DailyCaffeine;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $language = app()->getLocale();

        $searchResults = (new Search())
            ->registerModel(Activity::class, "name->".$language)->limitAspectResults(5)
            ->registerModel(Allergy::class, 'name->'.$language)->limitAspectResults(5)
            ->registerModel(CallResult::class, 'note')->limitAspectResults(5)
            ->registerModel(Clinic::class, 'name')->limitAspectResults(5)
            ->registerModel(DailyCaffeine::class, 'name->'.$language)->limitAspectResults(5)
            ->registerModel(Contact::class, 'name', 'phone', 'email', 'subject', 'message')->limitAspectResults(5)
            ->search($request->search_key);
            
        return $searchResults;
    }
}
