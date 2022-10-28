<?php

namespace App\Http\Controllers;

use App\Filter\MealFilter;
use App\Http\Requests\MealRequest;
use App\Http\Resources\MealItemResource;
use App\Models\Language;
use App\Models\MealItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{
    public function handleRequest(MealRequest $request)
    {
        $pagination = isset($request->per_page) ? $request->per_page : MealItem::withTrashed()->count();

        Language::where('lang', $request->lang)->firstOrFail();

        $with = explode(',', $request->with);

        if (count($with) > 3) {
            return response()->json(['errors' => "Too many arguments given in 'with' parameter"], 400);
        }

        $filter = new MealFilter($with, $request->category, $request->tags, $request->diff_time);

        $data = $filter->filter();
        return MealItemResource::collection($data->paginate($pagination))->additional(['version' => '1.1.0', 'Author' => 'Valentino Janjac']);
    }
}
