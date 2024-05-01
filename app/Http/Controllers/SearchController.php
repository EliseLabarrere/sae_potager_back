<?php

namespace App\Http\Controllers;
use App\Models\Plant;


use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchPlant(Request $request)
    {
        $searchData = $request->searchData;
        $plants = Plant::search($searchData)->get();
    
        $results = [];
        foreach ($plants as $plant) {
            $results[] = [
                'id' => $plant->id,
                'name' => $plant->name,
            ];
        }
    
        return $results;
    }
    
}
