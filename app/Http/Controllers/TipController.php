<?php

namespace App\Http\Controllers;
use App\Models\Tip;

use Illuminate\Http\Request;

class TipController extends Controller
{
    //TIPS
    /**
     * GET tips
     */
    public function getTips(){
        $tips = Tip::orderBy('created_at', 'desc')->get();
        $tips->load('plants:id,name,img');
        return response()->json($tips);
    }
    

    //TIPS
    /**
     * GET tip by id
     */
    public function getTipById($id){
        $tip = Tip::findOrFail($id);
        $tip->load('keywords:title', 'plants:id,name,img');
        return response()->json($tip);
    }
}
