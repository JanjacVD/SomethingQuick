<?php

namespace App\Http\Controllers;

use App\Filter\MealFilter;
use App\Http\Resources\MealItemResource;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{
    public function handleRequest(Request $request)
    {
        $type = gettype($request->category);
        if ($type === "string") {
            $rules = ['in:null,!null'];
        } else {
            $rules = ['numeric'];
        }

        $validate = Validator::make($request->toArray(), [
            'page' => ['integer'],
            'lang' => ['required', 'string'],
            'per_page' => ['integer'],
            'category' => $rules,
            'tags' => ['string'],
            'with' => ['string'],
            'diff_time' => ['numeric']
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 400);
        }
        $lang = Language::where('lang', $request->lang)->firstOrFail();
        $with = explode(',', $request->with);
        if(count($with) > 3){
            return response()->json(['errors' => "Too many arguments given in 'with' parameter"], 400);
        }
        $filter = new MealFilter($with, $request->category, $request->tags, $request->diff_time);
        $data = $filter->filter();
        if($request->per_page !== null){
            return MealItemResource::collection($data->paginate($request->per_page))->additional(['version' => '1.0.0', 'Author' => 'Valentino Janjac']);
        }
        else{
            return MealItemResource::collection($data->get())->additional(['version' => '1.0.0', 'Author' => 'Valentino Janjac']);
        }
    }
}
