<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\M_AD_CoinCharge_Message;
use App\Models\M_AD_News;
use App\Models\M_AD_Track;
use App\Models\M_Fav_Type;
use App\Models\M_Product;
use App\Models\T_AD_CoinCharge;
use App\Models\T_AD_Order;
use App\Models\T_CU_Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerInfoController extends Controller
{
    /*
    * Create:Zarni(2022/01/12) 
    * Update: 
    * This is function is to show admin Customer Listing
    * Return is view (customerInfo.blade.php)
    */
    public function customerInfo()
    {

        Log::channel('adminlog')->info("CustomerInfoController", [
            'Start customerInfo'
        ]);

        $customer1 = new T_CU_Customer();
        $customer = $customer1->customerInfoList();

        Log::channel('adminlog')->info("CustomerInfoController", [
            'End customerInfo'
        ]);

        return view('admin.customerInfo.customerInfo', ['t_cu_customer' => $customer]);
    }
    /*
    * Create:Zarni(2022/01/12) 
    * Update: 
    * This is function is to show Customer detail orderListing
    * Return is view (customerinfoDetail.blade.php)
    */
    public function customerinfoDetail(Request $request)
    {

        Log::channel('adminlog')->info("CustomerInfoController", [
            'Start customerinfoDetail'
        ]);

        $customerd = new T_CU_Customer();
        $cusdetail = $customerd->customerDetail($request->input('id'));
        if ($cusdetail == null) abort(404);
        // Log::critical('asdasd',[$cusdetail,$request->input('id')]);
        $custrans = new T_AD_Order();
        $trans = $custrans->Usertransaction($request->input('id'));
        if ($trans == null) abort(404);
        // return $trans;
        $coin = new T_AD_CoinCharge();
        $cuscoin = $coin->UsercoinchargeList($request->input('id'));

        Log::channel('adminlog')->info("CustomerInfoController", [
            'End customerinfoDetail'
        ]);

        return view('admin.customerInfo.customerinfoDetail', ['cusdetail' => $cusdetail, 't_ad_order' => $trans, 'cuscoin' => $cuscoin]);
    }

    /*
      * Create : Zar Ni(20/1/2022)
      * Update :
      * Explain of function : To show customer name search
      * Prarameter : no
      * return :
    */
    public function customerSearch(Request $request)
    {

        Log::channel('adminlog')->info("CustomerInfoController", [
            'Start customerSearch'
        ]);

        $cus = new T_CU_Customer();
        $namelist = $cus->cusSearch($request);

        Log::channel('adminlog')->info("CustomerInfoController", [
            'End customerSearch'
        ]);

        return response()
            ->json(
                $namelist
            );
    }
    /*
      * Create : Zar Ni(20/1/2022)
      * Update :
      * Explain of function : To show customer id search
      * Prarameter : no
      * return :
    */
    public function customeridSearch(Request $request)
    {

        Log::channel('adminlog')->info("CustomerInfoController", [
            'Start customeridSearch'
        ]);

        $customerid = new T_CU_Customer();
        $searchid = $customerid->cusidSearch($request);

        Log::channel('adminlog')->info("CustomerInfoController", [
            'End customeridSearch'
        ]);

        return response()
            ->json(
                $searchid
            );
    }

    /*
    * Create:zayar(2022/02/03) 
    * Update: 
    * This is function is to get customer details
    * Return is view (customer.blade.php)
    */
    public function customerDetailSearch(Request $request)
    {
        $messageLimited = [];
        $tracksLimited = [];
        $messagecount = 0;
        $trackcount = 0;
        if (session()->has('customerId')) {
            $sessionCustomerId = session()->get('customerId');
            $messages = new M_AD_CoinCharge_Message();
            $messageLimited = $messages->informMessage($sessionCustomerId);
            $allmessage = $messages->allMessage($sessionCustomerId);
            $allMessageToCount = $messages->allMessageToCount($sessionCustomerId);
            $messagecount = count($allMessageToCount);

            $tracks = new M_AD_Track();
            $tracksLimited = $tracks->trackLimited($sessionCustomerId);
            $productIds = [];
            foreach ($tracksLimited as $key => $value) {
                $ids = (int)$value->title;
                array_push($productIds, $ids);
            }
            $product = new M_Product();
            $searchProduct = $product->searchProduct($productIds);
            $alltracks = $tracks->allTracks($sessionCustomerId);
            $allTracksToCount = $tracks->allTracksToCount($sessionCustomerId);
            $trackcount = count($allTracksToCount);

            $user = new T_CU_Customer();
            $userinfo = $user->loginUser($sessionCustomerId);
        }
        $news = new M_AD_News();
        $newDatas = $news->newsAll();
        $newsAllToCount = $news->newsAllToCount();
        $newsCount = count($newsAllToCount);
        $newsLimited = $news->newsLimited();

        $informBadgeCount = $newsCount + $trackcount + $messagecount;


        return response()
            ->json([
                'detail' => $userinfo,
                'allnews' => $newDatas,
                'limitednews' => $newsLimited,
                'allmessages' => $allmessage,
                'limitedmessages' => $messageLimited,
                'alltracks' => $alltracks,
                'limitedtracks' => $tracksLimited,
                'allmessages' => $allmessage,
                'alertcount' => $informBadgeCount,
                'trackProduct' => $searchProduct
            ]);
    }
}
