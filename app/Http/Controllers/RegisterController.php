<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index(){

        if(Session("LoggedUser"))
        return redirect("/products/all/type/9/updated_at/desc");

        $districts = DB::select("SELECT * FROM districts");
        $info = ["districts"=>$districts];

        return view('auth-register.register', $info);
    }

    public function register_user(Request $request){
        $request->validate([
            "email"=>"required|unique:users|max:150|min:3",
            "full_name"=>"required|max:40|min:3",
            "phone"=>"required|max:10|min:10|unique:users",
            "password"=>"required|max:25|min:6"
        ]);

        $register = new User();
        $register->full_name = $request->full_name;
        $register->email = $request->email;
        $register->password = Hash::make($request->password);
        $register->phone = $request->phone;

        $saved = $register->save();

        if($saved)
        return redirect("/login");
        else
        return "<h3>OOPS Something went wrong, please try again</h3>";
    }
}
