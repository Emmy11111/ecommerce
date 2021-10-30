<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Validator;

class ProfileController extends Controller
{
    public function index(){

        if(!Session("LoggedUser"))
        return redirect("/login")->with("auth", "You must login first");

        $districts = DB::select("SELECT * FROM districts");
        
        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo];

        return view('profile', $info);
    }

    public function uploadProfile(Request $request){
        $userId = Session("LoggedUser");
        $validateImage = validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
        ]);

        if(!$validateImage->passes()){
            $valErrors =  $validateImage->errors()->all();
            return back()->with("fail", $valErrors[0]);
        }

        $imageName = $request->file->getClientOriginalName();
        $file_path = public_path('uploads/' . $imageName);

        while(file_exists($file_path)){
        $imageName.= "1profile".$request->file->extension();
        $file_path = public_path('uploads/' . $imageName);
        }

        if(!file_exists($file_path)){
            $uploaded = $request->file->move(public_path('uploads'), $imageName);
            if($uploaded){
            $info = User::find($userId);
            $prevImage = $info->profile;
            $info->profile = "/uploads/".$imageName;
            $info->update();
            if($prevImage != "/images/user.png"){
            unlink(public_path($prevImage));
            }
            return back();
        }else{
            return back()->with("fail","Something went wrong, please try again");
        }
        }else{
            return back()->with("fail","Image failed to be uploaded, please try to rename your image");
        }
    }

}