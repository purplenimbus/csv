<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\VehicleMake;
use App\VehicleModel;

class MakeController extends Controller
{
    public function getMake($id){
		$make = VehicleMake::find($id);
		
		$data = [
					'uuid' => $make->uuid,
					'name' => $make->name,
					'value' => $make->name,
					'models' => $make->models
				];
		
		return response()->json($data,200);
	}
}
