<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class M_Product extends Model
{
    use HasFactory;
    public $table = 'm_product';

    /*
    * Create : Min Khant(14/1/2022)
    * Update :
    * Explain of function : To get product data
    * Prarameter : no
    * return : 
    */
    public function products($id)
    {
        Log::channel('customerlog')->info('M_Product Model', [
            'start products'
        ]);

        $product = M_Product::select(['id', 'product_name', 'coin', 'amount'])
            ->where('id', '=', $id)
            ->where('del_flg', '=', 0)
            ->first();

        Log::channel('customerlog')->info('M_Product Model', [
            'end products'
        ]);

        return $product;
    }

    /* Create : Aung Min Khant(21/1/2022)
    * Update :
    * Explain of function : To getall data from m_product databse and m_fav_type and m_taste
    * parament : none
    * return all data
    * */

    public function getAllProducts()
    {
        Log::channel('adminlog')->info("M_Product Model", [
            'Start Product List'
        ]);
        $product = DB::table('m_product')
            ->select('*', DB::raw('m_product.id AS pid'))
            ->join('m_fav_type', 'm_fav_type.id', '=', 'm_product.product_type')
            ->join('m_taste', 'm_taste.id', '=', 'm_product.product_taste')
            ->where('m_product.del_flg', 0)
            ->orderBy('avaliable','DESC')
            ->paginate(10);

        Log::channel('adminlog')->info("M_Product Model", [
            'End Product List'
        ]);
    
        return $product;
    }

    /*
    * Create : Aung Min Khant(18/1/2022)
    * Update :
    * Explain of function : To save data for m_product databse 
    * parament : request from product add form
    * return save data
    * */
    public function saveData($request)
    {

        Log::channel('adminlog')->info("M_Product_ Model", [
            'Start save Data'
        ]);

        $mrate = new M_AD_CoinRate();
        $rates = $mrate->getRate();
        $amount = $request->input('coin') * $rates->rate;
        $product = new M_Product();
        $product->product_name = $request->input('pname');
        $product->product_type = $request->input('ptype');
        $product->product_taste = $request->input('ptaste');
        $product->coin = $request->input('coin');
        $product->amount = $amount;
        $product->list = $request->input('list');
        $product->description = $request->input('pdesc');
        $product->avaliable = $request->has('avaliable') ? 1 : 0;
        $product->save();


        Log::channel('adminlog')->info("M_Product Model", [
            'End save data'
        ]);
        return $product;
    }

    /*
    * Create : Aung Min Khant(22/2/2022)
    * Update :
    * Explain of function : To change amount when admin change rate
    * parament : none
    * return change amount
    * */
    public function changeAmount($rate)
    {

        Log::channel('adminlog')->info("M_Product Model", [
            'Start changeAmount'
        ]);
    
        $product = DB::select(
            DB::raw("
            UPDATE
            m_product
            SET
            amount = coin * $rate
            "));
          
        Log::channel('adminlog')->info("M_Product Model", [
            'End changeAmount'
        ]);
            
    }


    /*
    * Create : Aung Min Khant(20/1/2022)
    * Update :
    * Explain of function : To get  data with specific id from m_product databse 
    * parament : specific id from  product list table
    * return get data
    * */
    public function getDataById($id)
    {

        Log::channel('adminlog')->info("M_Product_ Model", [
            'Start getDataById'
        ]);
        $mProduct = M_Product::findOrfail($id);

        Log::channel('adminlog')->info("M_Product_ Model", [
            'End get DataById'
        ]);
        return $mProduct;
    }
    /*
    * Create : Aung Min Khant(19/1/2022)
    * Update :
    * Explain of function : To update data for m_product databse 
    * parament : request from product edit form
    * return update data
    * */

    public function updateData($request, $id)
    {
        Log::channel('adminlog')->info("M_Product Model", [
            'Start updateData'
        ]);

        $mrate = new M_AD_CoinRate();
        $rates = $mrate->getRate();
        $amount = $request->input('coin') * $rates->rate;
        $product = M_Product::find($id);
        $product->product_name = $request->input('pname');
        $product->product_type = $request->input('ptype');
        $product->product_taste = $request->input('ptaste');
        $product->coin = $request->input('coin');
        $product->amount = $amount;
        $product->list = $request->input('list');
        $product->description = $request->input('pdesc');
        $product->avaliable = $request->has('avaliable') ? 1 : 0;
        $product->save();

        Log::channel('adminlog')->info("M_Product Model", [
            'End updateData'
        ]);


        return $product;
    }

    /*
    * Create : Aung Min Khant(28/1/2022)
    * Update :
    * Explain of function : To show data to customer product page
    * parament : none
    * return product data
    * */

    public function showProductList()
    {


        Log::channel('adminlog')->info("M_Product Model", [
            'Start showProductList'
        ]);

        $product = DB::table('m_product')
            ->select(['*'], DB::raw('m_product.id'))
            ->join('t_ad_photo', 't_ad_photo.link_id', '=', 'm_product.id')
            ->where('m_product.avaliable', 1)
            ->where('t_ad_photo.order_id', 1)
            ->where('t_ad_photo.del_flg', 0)
            ->where('m_product.del_flg', 0)
            ->orderBy('m_product.id')
            ->take(4)
            ->get();


        Log::channel('adminlog')->info("M_Product Model", [
            'End showProductList'
        ]);

        return $product;
    }

    /*
    * Create : Aung Min Khant(28/1/2022)
    * Update :
    * Explain of function : To search product data to customer product page
    * parament : none
    * return product data
    * */

    public function searchById($id)
    {

        Log::channel('adminlog')->info("M_Product Model", [
            'Start searchById'
        ]);



        $product = DB::table('m_product')
            ->select('*', DB::raw('m_product.id AS pid'))
            ->join('m_fav_type', 'm_fav_type.id', '=', 'm_product.product_type')
            ->join('m_taste', 'm_taste.id', '=', 'm_product.product_taste')
            ->where('m_product.id', $id)
            ->where('m_product.avaliable', 1)
            ->where('m_product.del_flg', 0)
            ->first();
       

        Log::channel('adminlog')->info("M_Product Model", [
            'End searchById'
        ]);

        return $product;
    }


    /*
    * Create : Aung Min Khant(28/1/2022)
    * Update :
    * Explain of function : To search product data to customer product page
    * parament : none
    * return product data
    * */

    public function searchByType($request)
    {

        Log::channel('adminlog')->info("M_Product Model", [
            'Start searchByType'
        ]);

        $product = DB::table('m_product')
            ->select(['*'], DB::raw('m_product.id'))
            ->join('t_ad_photo', 't_ad_photo.link_id', '=', 'm_product.id')
            ->join('m_fav_type', 'm_fav_type.id', '=', 'm_product.product_type')
            ->join('m_taste', 'm_taste.id', '=', 'm_product.product_taste')
            ->where('m_product.product_type', '=', (int)$request)
            ->where('m_product.avaliable', 1)
            ->where('t_ad_photo.order_id', 1)
            ->where('t_ad_photo.del_flg', 0)
            ->where('m_product.del_flg', 0)
            ->orderBy('m_product.id')
            ->get();


        Log::channel('adminlog')->info("M_Product Model", [
            'End searchByType'
        ]);

        return $product;
    }


    /*
    * Create : Aung Min Khant(28/1/2022)
    * Update :
    * Explain of function : To search product data to customer product page
    * parament : none
    * return product data
    * */

    public function searchByTaste($request)
    {

        Log::channel('adminlog')->info("M_Product Model", [
            'Start searchByTaste'
        ]);

        $product = DB::table('m_product')
            ->select(['*'], DB::raw('m_product.id'))
            ->join('t_ad_photo', 't_ad_photo.link_id', '=', 'm_product.id')
            ->join('m_fav_type', 'm_fav_type.id', '=', 'm_product.product_type')
            ->join('m_taste', 'm_taste.id', '=', 'm_product.product_taste')
            ->where('m_product.product_taste', '=', (int)$request)
            ->where('m_product.avaliable', 1)
            ->where('t_ad_photo.order_id', 1)
            ->where('t_ad_photo.del_flg', 0)
            ->where('m_product.del_flg', 0)
            ->orderBy('m_product.id')
            ->get();


        Log::channel('adminlog')->info("M_Product Model", [
            'End searchByTaste'
        ]);

        return $product;
    }




    public function productDetail()
    {

        return $this->hasMany('App\Models\M_Product_Detail');
    }

    /*
      * Create : Zar Ni(15/1/2022)
      * Update :
      * Explain of function : To get data for DashboardProductMiniList
      * Prarameter : no
      * return :
    */
    public function DashboardproductList()
    {

        Log::channel('adminlog')->info("M_Product Model", [
            'Start DashboardproductList'
        ]);

        $dashboardproduct = M_Product::join('m_taste', 'm_taste.id', '=', 'm_product.product_taste')
            ->join('m_fav_type', 'm_fav_type.id', '=', 'm_product.product_type')
            ->limit(5)
            ->get();

        Log::channel('adminlog')->info("M_Product Model", [
            'End DashboardproductList'
        ]);

        return $dashboardproduct;
    }




    /*
     * Create : Min Khant(23/1/2022)
     * Update :
     * Explain of function : get product data
     * Prarameter : no
     * return : product data
     * */
    public function productInfo()
    {
        Log::channel('customerlog')->info('M_Product Model', [
            'start productInfo'
        ]);
        $products = M_Product::select(['id', 'product_name', 'coin'])
            ->where('avaliable', '=', 1)
            ->where('del_flg', '=', 0)
            ->get();
        Log::channel('customerlog')->info('M_Product Model', [
            'end productInfo'
        ]);
        return $products;
    }

    /*
      * Create : Min Khant(1/2/2022)
      * Update :
      * Explain of function : To get customer fav product data
      * Prarameter : no
      * return : customer fav product data
    */
    public function customerFavType($id)
    {
        Log::channel('customerlog')->info("T_CU_Customer Model", [
            'Start customerInformation'
        ]);

        $result = DB::table('m_product')
            ->select(['*'], DB::raw('m_product.id'))
            ->join('t_ad_photo', 't_ad_photo.link_id', '=', 'm_product.id')
            ->where('m_product.avaliable', 1)
            ->where('t_ad_photo.order_id', 1)
            ->where('t_ad_photo.del_flg', 0)
            ->where('m_product.del_flg', 0)
            ->where('m_product.product_type', $id)
            ->orderBy('m_product.id')
            ->limit(1)
            ->get();

        Log::channel('customerlog')->info("T_CU_Customer Model", [
            'End customerInformation'
        ]);

        return $result;
    }
    /*
      * Create :zayar(15/2/2022)
      * Update :
      * Explain of function : To search Product
      * Prarameter : no
      * return : customer track product data
    */
    public function  searchProduct($productIds)
    {
        Log::channel('customerlog')->info("T_CU_Customer Model", [
            'Start searchProduct'
        ]);
        Log::channel('customerlog')->info("asdf", [
            $productIds
        ]);
        $result = M_Product::where('m_product.avaliable', 1)
            ->where('m_product.del_flg', 0)
            ->whereIn('m_product.id', $productIds)
            ->get();


        Log::channel('customerlog')->info("T_CU_Customer Model", [
            'End searchProduct'
        ]);
        Log::channel('customerlog')->info("asdf", [
            $result
        ]);
        return $result;
    }
}
