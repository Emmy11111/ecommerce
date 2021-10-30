<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Products;

class ProductController extends Controller
{
    public function index(){

        if(!Session("LoggedUser"))
        return redirect("/login")->with("auth", "You must login first");

        $districts = DB::select("SELECT * FROM districts order by namedistrict asc");
        $sectors = DB::select("SELECT * FROM sectors order by namesector asc");
        $cells = DB::select("SELECT * FROM cells order by namecell asc");
        $product_type = DB::select("SELECT * FROM product_types limit 8");
        
        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"sectors"=>$sectors,"cells"=>$cells];

        return view('add_product', $info);
    }

    public function add_product(Request $request){
        $request->validate([
          "title"=>"required|max:100|min:1",
          "price"=>"required|max:50|min:1",
          'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:15000',
          'district'=>"required|max:50",
          "sector"=>"required|max:50",
          "cell"=>"required|max:50",
          "phone"=>"required|max:10|min:10",
          "category"=>"required|max:100"
        ]);

        $imageName = $request->file->getClientOriginalName();
        $file_path = public_path('products/' . $imageName);

        while(file_exists($file_path)){
        $imageName.= "1product".$request->file->extension();
        $file_path = public_path('products/' . $imageName);
        }

        if(!file_exists($file_path)){
            $uploaded = $request->file->move(public_path('products'), $imageName);
            if($uploaded){

                $save = new Products;

                $save->title = $request->title;
                $save->price = $request->price;
                $save->file = "/products/".$imageName;
                $save->district = $request->district;
                $save->sector = $request->sector;
                $save->cell = $request->cell;
                $save->phone = $request->phone;
                $save->category = $request->category;
                $save->userId = Session("LoggedUser");

                $save->save();
            
                return redirect("/products/all");
        }else{
            return back()->with("fail","Something went wrong, please try again");
        }
        }else{
            return back()->with("fail","Image failed to be uploaded, please try to rename your image");
        }
    }

    public function productsKgl($type,$item,$cond){

        $districts = DB::select("SELECT * FROM districts");
        $product_type = DB::select("SELECT * FROM product_types order by type asc");
        $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and p.category = $type and (p.district = 102 || p.district = 103 || p.district = 101) order by $item $cond limit 12");
        
        if($type == 9){
        $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and (p.district = 102 || p.district = 103 || p.district = 101) order by $item $cond limit 12");
        }

        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"products"=>$products,"url"=>"/products/all/kigali/type/$type","item"=>$item,"cond"=>$cond,"p_type"=>$type];

        return view('home', $info);
    }

    public function allProducts(){
        if(!Session("LoggedUser"))
        return redirect("/login")->with("auth", "You must login first");

        $userId = Session("LoggedUser");

        $userInfo = User::where("id","=",$userId)->first();
        
        $products = DB::select("SELECT p.*,c.type,d.*,se.*,ce.* FROM products p,product_types c,districts d,sectors se,cells ce where c.id = p.category and p.district = d.districtcode and p.sector = se.sectorcode and p.cell = ce.codecell and userId = $userId");
        $info = ["userInfo"=>$userInfo,"products"=>$products];

        return view("products", $info);
    }

    public function deleteProduct($id){
        if(!Session("LoggedUser"))
        return redirect("/login")->with("auth", "You must login first");

        $userId = Session("LoggedUser");

        $info = DB::select("SELECT * FROM products WHERE id = $id");
        unlink(public_path($info[0]->file));
        DB::delete("DELETE FROM products WHERE id = $id and userId = $userId");

        return back();
    }

    public function editProduct($id){    
        if(!Session("LoggedUser"))
        return redirect("/login")->with("auth", "You must login first");
        
        $userId = Session("LoggedUser");
        $userInfo = User::where("id","=",$userId)->first();

        $districts = DB::select("SELECT * FROM districts order by namedistrict asc");
        $sectors = DB::select("SELECT * FROM sectors order by namesector asc");
        $cells = DB::select("SELECT * FROM cells order by namecell asc");
        $product_type = DB::select("SELECT * FROM product_types limit 8");
        $product = DB::select("SELECT * FROM products WHERE id = $id and userId = $userId");

        if(count($product)==0){
            return back();
        }
        
        $userId = Session("LoggedUser");
        
        $userInfo = User::where("id","=",$userId)->first();
        
        $info = ["districts"=>$districts,"userInfo"=>$userInfo,"product_type"=>$product_type,"sectors"=>$sectors,"cells"=>$cells,"product"=>$product];

        return view('edit_product', $info);
    }

    public function update_product(Request $request){
        $userId = Session("LoggedUser");

        $request->validate([
          "title"=>"required|max:100|min:1",
          "price"=>"required|max:50|min:1",
          'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:15000',
          'district'=>"required|max:50",
          "sector"=>"required|max:50",
          "cell"=>"required|max:50",
          "phone"=>"required|max:10|min:10",
          "category"=>"required|max:100"
        ]);

        $imageName = substr($request->prevfile, 10,strlen($request->prevfile));

        $uploaded = false;
        if(isset($request->file)){
            $imageName = $request->file->getClientOriginalName();
            $file_path = public_path('products/' . $imageName);
    
            while(file_exists($file_path)){
            $imageName.= "1product".$request->file->extension();
            $file_path = public_path('products/' . $imageName);
            }

            if(!file_exists($file_path)){
                $uploaded = $request->file->move(public_path('products'), $imageName);
            }
        }


        $prId = $request->route('id');
        $updated = DB::update("UPDATE products SET 
        title = '$request->title',
        price = '$request->price',
        file = '/products/$imageName',
        district = '$request->district',
        sector= '$request->sector',
        cell = '$request->cell',
        phone = '$request->phone',
        category = '$request->category',
        userId = '$userId'
        WHERE id = $prId and userId = $userId
        ");

         if($updated){

            if(isset($request->file) and strlen($request->file->getClientOriginalName())>0){
                unlink(public_path($request->prevfile));
            }
        }
        return redirect("/products/all");

        // }else{
        //     return back()->with("fail","Something went wrong, please try again");
        // }
        // }else{
        //     return back()->with("fail","Image failed to be uploaded, please try to rename your image");
        // }
    }

}