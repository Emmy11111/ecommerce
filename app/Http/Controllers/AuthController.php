<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function index(){

        if(Session("LoggedUser"))
        return redirect("/products/all/type/9/updated_at/desc");
        
        $districts = DB::select("SELECT * FROM districts");
        $info = ["districts"=>$districts];

        return view('auth-register.login',$info);
    }

    public function auth(Request $request){

        $request->validate([
            "email"=>"required",
            "password"=>"required"
        ]);

        $userInfo = User::where('email','=',$request->email)->first();

        if(!$userInfo){
            return back()->with("fail","Incorrect email or password");
        }else{

           if(Hash::check($request->password, $userInfo->password)){
            $request->session()->put("LoggedUser", $userInfo->id);

            if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
                if(!isset($request->remember_me) && $_COOKIE["email"] == $userInfo->email && $_COOKIE['password'] == $request->password){
                    setcookie("email", "");
                    setcookie("password", "");
                }
            }

            if(isset($request->remember_me)){
                setcookie("email", $request->email);
                setcookie("password", $request->password);
            }

            return redirect("/products/all/type/9/updated_at/desc");
           }else{
            return back()->with("fail","Incorrect email or password");
           }
        }
    }

    public function logout(){

        if(!Session("LoggedUser"))
        return redirect("/products/all/type/9/updated_at/desc");

        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/products/all/type/9/updated_at/desc');
        }
    }
}
