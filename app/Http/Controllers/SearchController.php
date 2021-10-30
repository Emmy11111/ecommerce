<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request){

        if(strlen(trim($request->key)) < 3){
            $search_results = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.title like '$request->key%' limit 6");

            if(count($search_results) == 0){
                $search_results = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.title like '%$request->key%' limit 6");
            }
        }
        
        if(strlen(trim($request->key))>2){
            $search_results = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.title like '%$request->key%' limit 12");
        }
        return redirect("/products/all/type/9/updated_at/desc")->with("search_results",$search_results);
    }
}