<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStagiaireRequest;
use App\Http\Requests\UpdateStagiaireRequest;
use App\Models\StagiaireModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Str;

class Stagiaire extends Controller
{
   
    public function index(){

        $stagiaires = StagiaireModel::orderByDesc('created_at')->get();

        if(count($stagiaires)){
            return view('stagiaires' ,compact('stagiaires'));
        }

        return to_route('stagiaires.create');
    }

 
    
    public function create(){
        return view('form');
    }

    public function store(StoreStagiaireRequest $request)
    {

        $imgPath = $request->image->store('public/images');
        $path = 'storage/'.Str::after($imgPath,'public/');
        StagiaireModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'section' => $request->section,
            'image' => $path,
        ]);

        return to_route('stagiaires');
       
    }

    public function show(StagiaireModel $stagiaireModel)
    {
      $stagiaire = $stagiaireModel;
        return view('showStag',compact('stagiaire'));
    }


    public function edit(StagiaireModel $stagiaireModel)
    {
        $stagiaire = $stagiaireModel;
        return view('editStag',compact('stagiaire'));
    }



    public function update(UpdateStagiaireRequest $request,StagiaireModel $stagiaireModel){
       

if($request->hasFile('image')){
    //DELETE OLD IMAGE
    $path = Str::after($stagiaireModel->image,'storage/');
    Storage::delete('public/'.$path);
// CREATE NEW IMAGE
    $newImage= $request->image->store('public/images');
    $newPath ='storage/'.Str::after($newImage,'public/');
    
    $stagiaireModel->update([
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'section'=>$request->section,
        'image' => $newPath
    ]);
}

else{
    
    $stagiaireModel->update([
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'section'=>$request->section,
        
    ]);
}


        return  to_route('stagiaires');

    }




    public function destroy(StagiaireModel $stagiaireModel)
    {

        $stagiaireModel->delete();
        $path = Str::after($stagiaireModel->image,'storage/');
        Storage::delete('public/'.$path);
      

        return back();
    }




}
