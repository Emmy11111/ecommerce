<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){

        $districts = DB::select("SELECT * FROM districts");
        $product_type = DB::select("SELECT * FROM product_types order by type asc");
        $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell order by p.updated_at desc ");
        
        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"products"=>$products,"url"=>"all_asc"];

        return view('home', $info);
    }

    public function products_desc(){

        $districts = DB::select("SELECT * FROM districts");
        $product_type = DB::select("SELECT * FROM product_types order by type asc");
        $products = DB::select("SELECT p.*,c.type FROM products p,product_types c where c.id = p.category order by p.updated_at asc ");
        
        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"products"=>$products,"url"=>"all_desc"];

        return view('home', $info);
    }

    public function price($cond){

        $districts = DB::select("SELECT * FROM districts");
        $product_type = DB::select("SELECT * FROM product_types order by type asc");
        $products = DB::select("SELECT p.*,c.type FROM products p,product_types c where c.id = p.category order by p.price $cond ");
        
        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"products"=>$products,"url"=>"all_price_$cond"];

        return view('home', $info);
    }

    public function district($type,$item,$cond,$district){

        $districts = DB::select("SELECT * FROM districts");
        $product_type = DB::select("SELECT * FROM product_types order by type asc");
        
        if($type == 9){
            $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.district = $district order by $item $cond ");
            if($district == 1){
                $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell order by $item $cond ");
            }
        }
        else{
            $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.category = $type and p.district = $district order by $item $cond ");
        }

        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"products"=>$products,"url"=>"/products/all/type/$type","p_type"=>$type,"item"=>$item,"cond"=>$cond,"dist"=>$district];

        return view('home', $info);
    }

    public function types($type,$item,$cond){

        $districts = DB::select("SELECT * FROM districts");
        $product_type = DB::select("SELECT * FROM product_types order by type asc");
        $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.category = $type order by $item $cond ");
        
        if($type == 9){
        $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell order by $item $cond ");
        }

        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"products"=>$products,"url"=>"/products/all/type/$type","item"=>$item,"cond"=>$cond,"p_type"=>$type];

        return view('home', $info);
    }

    public function kigali($type,$item,$cond){
        $districts = DB::select("SELECT * FROM districts");
        $product_type = DB::select("SELECT * FROM product_types order by type asc");
        $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.category = $type and (p.district = 102 || p.district = 103 || p.district = 101) order by $item $cond ");
        
        if($type == 9){
        $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.district = 102 || p.district = 103 || p.district = 101 order by $item $cond ");
        }

        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"products"=>$products,"url"=>"/products/all/type/$type","item"=>$item,"cond"=>$cond,"p_type"=>$type];

        return view('home', $info);
    }
}
