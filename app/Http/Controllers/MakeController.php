<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\VehicleMake;
use App\VehicleModel;

class MakeController extends Controller
{
    public function getMake($id){
		$make = VehicleMake::find($id);
		
		$make->load('models');
		
		return response()->json($make,200);
	}
	
	public function getMakes(){
		$makes = VehicleMake::all();
		
		$makes->load('models');
		
		return response()->json($makes,200);
	}
}
