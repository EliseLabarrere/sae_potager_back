<?php

namespace App\Http\Controllers;
use App\Models\CategPlant;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    //CATEG PLANTS
    /**
     * GET categPlants
     */
    public function getCategPlant(){
        return CategPlant::with('plants')->get();
    }

    /**
     * GET categPlant by id
     *
     * @urlParam id int required id of the categPlant.
     */
    public function getCategPlantById($id){
        $Res = CategPlant::with('plants')->findOrFail($id);

        return response()->json($Res);
    }

    //PLANTS
    /**
     * GET plants
     */
    public function getPlant(){
        return Plant::get();
    }

    /**
     * GET Plant by id
     *
     * @urlParam id int required id of the Plant.
     */
    public function getPlantById($id) {
        $plant = Plant::findOrFail($id);
    
        $plant->load('categ_plant', 'categ_garden', 'compatibilities.otherPlant:id,name,img','tips:title,id,img,created_at');

        return response()->json($plant);
    }
    
    /**
     * GET Plant that corresponds to the sowing season
     */
    public function getPlantSeason(){
        $Res = Plant::where('start_month', '<=', date('m'))->where('end_month', '>=', date('m'))->get();
        return response()->json($Res);
    }
}
