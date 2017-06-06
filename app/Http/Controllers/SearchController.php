<?php

namespace App\Http\Controllers;

use App\Comment;
use App\GeneralModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{


    public function findForm()
    {
        return view('search.find');
    }

    public function find(Request $request)
    {


        $this->validate($request, ['places' => 'required', 'searchText' => 'required|min:1',]);

        $places = $request->places;
        if (!is_array($places))
            $places=['post','image','comment','tag','user','role','privilege','log'];
        $results = [];
        foreach ($places as $place) {
            $Model = 'App\\' . ucfirst($place);
            // get data with id
            $results[$place]=$Model::searchRecordsFor($request->searchText,true)->get();
        }
        return view('search.find',compact('results'));
    }


}
