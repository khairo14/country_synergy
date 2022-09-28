<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LocationsImport;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    //
    public function fLocation(){

        $num_loc = Locations::count();
        $loc = Locations::orderBy('name')->get();

        return view('locations.freezer')->with(['num_loc'=>$num_loc,'loc'=>$loc]);
    }

    public function addLocation(Request $request){
        $name = $request->name;

        if($name != null){
            $location = New Locations();
            $location->name = $name;
            $location->save();

            $status = 1;
            $message = 'Succesfully Added';
        }else{
            $status = 0;
            $message = 'Please Enter Location Name';
        }

        return response()->json(['message'=>$message,'status'=>$status]);
    }

    public function editLocation(Request $request){
        $id = $request->id;
        $name = $request->name;

        if($id != 0){
            if($name !=null){
                $edit_loc = Locations::find($id);
                $edit_loc->name = $name;
                $edit_loc->save();

                $status = 1;
                $message = "Location name Successfully updated";
            }else{
                $status = 0;
                $message = "Location Name Cannot be Empty";
            }
        }else{
            $status = 0;
            $message = "Failed to update Location name try again!";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function locationImport(Request $request){
        $file = $request->file;

        if($file){
            $extension = $file->getClientOriginalExtension();
            $filesize = $file->getSize();
            $valid_ext = array("csv","xlsx");
            $maxFileSize = 4194304;

            if(in_array(strtolower($extension), $valid_ext)){
                if($filesize <= $maxFileSize){
                    Excel::import(new LocationsImport,$file);
                    return response()->json(['message' => "Locations successfully uploaded","status"=>'1']);
                }else{
                    return response()->json(['message' => "No file was uploaded","status"=>'0']);
                }
            }else{
                return response()->json(['message' => "Invalid file extension","status"=>'0']);
            }
        }else{
            return response()->json(['message' => "No file was uploaded","status"=>'0']);
        }
    }

}
