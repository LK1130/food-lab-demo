<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\RangeChart;
use App\Rules\SearchDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class T_AD_Order extends Model
{
    public $table = 't_ad_order';
    use HasFactory;

    /* Create:Zarni(2022/01/16)
    * Update:
    * This is function is to show the data of admin ordertransactionDetail
    * Return
    */
    public function orderTransaction()
    {
        return T_AD_Order::all();
    }

    /* Create:Zarni(2022/01/16)
    * Update:
    * This is function is to show the data of admin ordertransactionDetail
    * Return
    */
    public function ordertransactionDetails($id)
    {

        Log::channel('adminlog')->info("T_AD_Order", [
            'Start ordertransactionDetails'
        ]);

        $ordertransactionDetail = T_AD_Order::select('*', DB::raw('t_ad_order.id AS orderid'))

            ->join('t_cu_customer', 't_cu_customer.id', '=', 't_ad_order.customer_id')
            ->leftjoin('m_ad_login', 'm_ad_login.id', '=', 't_ad_order.last_control_by')
            ->join('m_order_status', 'm_order_status.id', '=', 't_ad_order.order_status')
            ->join('m_township', 'm_township.id', '=', 't_ad_order.township_id')
            ->where('t_ad_order.del_flg', 0)
            ->where('t_ad_order.id', '=', $id)
            ->first();

        Log::channel('adminlog')->info("T_AD_Order", [
            'End ordertransactionDetails'
        ]);

        return $ordertransactionDetail;
    }

    /* Create:Zarni(2022/01/16)
    * Update:
    * This is function is to show the data of admin ordertransactionList
    * Return
    */
    public function OrderTransactions()
    {

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start OrderTransactions'
        ]);

        $ordertransactions = T_AD_Order::select('*', DB::raw('t_ad_order.id AS orderid'))
            ->join('t_cu_customer', 't_cu_customer.id', '=', 't_ad_order.customer_id')
            ->leftjoin('m_ad_login', 'm_ad_login.id', '=', 't_ad_order.last_control_by')
            ->join('m_order_status', 'm_order_status.id', '=', 't_ad_order.order_status')
            ->join('m_township', 'm_township.id', '=', 't_ad_order.township_id')
            ->orderby('t_ad_order.order_date', 'DESC')
            ->orderby('t_ad_order.order_time', 'DESC')
            ->where('t_ad_order.del_flg', 0)
            ->paginate(10);

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End OrderTransactions'
        ]);

        return $ordertransactions;
    }
    /* Create:Zarni(2022/01/16)
    * Update:
    * This is function is to show the data of admin Dashboardminitransaction List
    * Return
    */
    public function DashboardMinitrans()
    {

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start DashboardMinitrans'
        ]);

        $dashboardtrans = T_AD_Order::join('t_cu_customer', 't_cu_customer.id', '=', 't_ad_order.customer_id')
            ->join('m_order_status', 'm_order_status.id', '=', 't_ad_order.order_status')
            ->where('t_ad_order.del_flg', 0)
            ->orderby('t_ad_order.order_date', 'DESC')
            ->orderby('t_ad_order.order_time', 'DESC')
            ->limit(5)
            ->get();

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End DashboardMinitrans'
        ]);

        return $dashboardtrans;
    }
    /* Create:Zarni(2022/01/16)
    * Update:
    * This is function is to show the data of admin Dashboardtransaction Count
    * Return
    */
    public function Dashboardtranscount()
    {

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start Dashboardtranscount'
        ]);

        $transcount = T_AD_Order::where('t_ad_order.del_flg', 0)
            ->count('t_ad_order.id');

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End Dashboardtranscount'
        ]);

        return $transcount;
    }

    /* Create:Zarni(2022/01/16)
    * Update:
    * This is function is to show the data of admin Dashboard TodayOrder Count
    * Return
    */
    public function Todayordercount()
    {

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start Todayordercount'
        ]);

        $currentdate = Carbon::now()->day;
        $currentmonth = Carbon::now()->month;
        $currentyear = Carbon::now()->year;
        $todayorder = T_AD_Order::where(DB::raw(('day(order_date)')), $currentdate)
            ->where(DB::raw(('month(order_date)')), $currentmonth)
            ->where(DB::raw(('year(order_date)')), $currentyear)
            ->count();
        return $todayorder;

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End Todayordercount'
        ]);
    }
    /* Create:Zarni(2022/01/16)
    * Update:
    * This is function is to show the data of User's TransactionDetail
    * Return
    */
    public function Usertransaction($id)
    {

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start Usertransaction'
        ]);

        $userdetail = T_AD_Order::leftjoin('m_ad_login', 'm_ad_login.id', '=', 't_ad_order.last_control_by')
            ->join('m_order_status', 'm_order_status.id', '=', 't_ad_order.order_status')
            ->where('t_ad_order.del_flg', 0)
            ->where('t_ad_order.customer_id', '=', $id)
            ->paginate(10, ['*'], 'customerTrans');

        return $userdetail;

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End Usertransaction'
        ]);
    }


    public function orderDaily()
    {
        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start orderDaily'
        ]);

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $order = T_AD_Order::select(
            DB::raw('order_date as date'),
            DB::raw(('day(order_date) as day')),
            DB::raw('count(id) as totalorder'),
        )
            ->where(DB::raw('month(order_date)'), $currentMonth)
            ->where(DB::raw('year(order_date)'), $currentYear)
            ->orderBy(DB::raw('order_date'), 'ASC')
            ->groupBy('date')
            ->get();

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End orderDaily'
        ]);

        return $order;
    }
    public function orderMonthly()
    {
        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start orderMonthly'
        ]);

        $current = Carbon::now()->year;
        $order = T_AD_Order::select(

            DB::raw('year(order_date) as year'),
            DB::raw('month(order_date) as month'),
            DB::raw('count(id) as totalorder'),
        )
            ->where(DB::raw('year(order_date)'), $current)
            ->groupBy('year')
            ->groupBy('month')
            ->get();

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End orderMonthly'
        ]);

        return $order;
    }
    public function orderYearly()
    {
        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start orderYearly'
        ]);

        $current = Carbon::now()->year;
        $order = T_AD_Order::select(
            DB::raw('year(order_date) as year'),
            DB::raw('count(id) as totalorder'),
        )
            ->orderBy(DB::raw('year(order_date)'), 'ASC')
            ->groupBy('year')
            ->get();

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End orderYearly'
        ]);

        return $order;
    }
    public function orderRange($request)
    {
        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start orderRange'
        ]);

        $fromDate = $request['fromDate'];
        $toDate = $request['toDate'];

        $order = T_AD_Order::select(
            DB::raw('order_date as date'),
            DB::raw('count(id) as totalorder'),
        )
            ->where(DB::raw('order_date'), '>=', $fromDate)
            ->where(DB::raw('order_date'), '<=', $toDate)
            ->orderBy(DB::raw('order_date'), 'ASC')
            ->groupBy('date')
            ->get();

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End orderRange'
        ]);

        return $order;
    }
    /*
    * Create : Min Khant(14/1/2022)
    * Update :
    * Explain of function : To get order id
    * Prarameter : no
    * return : order id
    */
    public function orderId($id)
    {
        Log::channel('customerlog')->info('T_AD_Order Model', [
            'start orderId'
        ]);

        $orderID = T_AD_Order::where('customer_id', '=', $id)
            ->where('order_status', '=', 7)
            ->where('del_flg', '=', 0)
            ->get();

        Log::channel('customerlog')->info('T_AD_Order Model', [
            'end orderId'
        ]);

        return $orderID;
    }


    /*
    * Create : Zaw(2022/02/22)
    * Update :
    * This function is use to
    * Parameters :
    * Return :
    */
    public function orderDailyList()
    {
        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start orderDailyList'
        ]);

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $order = T_AD_Order::select(
            DB::raw('order_date as date'),
            DB::raw(('day(order_date) as day')),
            DB::raw('count(id) as totalorder'),
        )
            ->where(DB::raw('month(order_date)'), $currentMonth)
            ->where(DB::raw('year(order_date)'), $currentYear)
            ->orderBy(DB::raw('order_date'), 'ASC')
            ->groupBy('date')
            ->paginate(10);
        // ->get();

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End orderDailyList'
        ]);

        return $order;
    }

    public function ordermonthlyList()
    {
        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start ordermonthlyList'
        ]);

        $current = Carbon::now()->year;
        $order = T_AD_Order::select(

            DB::raw('year(order_date) as year'),
            DB::raw('monthname(order_date) as month'),
            DB::raw('count(id) as totalorder'),
        )
            ->where(DB::raw('year(order_date)'), $current)
            ->groupBy('year')
            ->groupBy('month')
            ->paginate(10);

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End ordermonthlyList'
        ]);

        return $order;
    }

    public function orderyearlyList()
    {
        Log::channel('adminlog')->info("T_AD_Order Model", [
            'Start orderYearly'
        ]);

        $current = Carbon::now()->year;
        $order = T_AD_Order::select(
            DB::raw('year(order_date) as year'),
            DB::raw('count(id) as totalorder'),
        )
            ->orderBy(DB::raw('year(order_date)'), 'DESC')
            ->groupBy('year')
            ->paginate(10);

        Log::channel('adminlog')->info("T_AD_Order Model", [
            'End orderYearly'
        ]);

        return $order;
    }
    /*
    * Create : Cherry(1/2/2022)
    * Update : Min Khant(1/2/2022)
    * Explain of function : To store custoemr order
    * Prarameter : no
    * return : no
    */
    public function customerOrder($id, $township, $products, $gCoin, $gCash, $phone)
    {
        Log::channel('customerlog')->info('T_AD_Order Model', [
            'start customerOrder'
        ]);
        DB::transaction(function () use ($id, $township, $products, $gCoin, $gCash, $phone) {
            $tAdOrder = new T_AD_Order();
            $tAdOrder->customer_id = $id;
            $tAdOrder->payment = 0;
            $tAdOrder->township_id = $township;
            $tAdOrder->ph_number = $phone;
            $tAdOrder->grandtotal_coin = $gCoin;
            $tAdOrder->grandtotal_cash = $gCash;
            $tAdOrder->order_status = 1;
            $tAdOrder->order_date =  date('Y-m-d');
            $tAdOrder->order_time = date('H:i:s');
            $tAdOrder->last_control_by = 0;
            $tAdOrder->save();

            foreach ($products as $product) {
                $tAdOrderDetail = new T_AD_OrderDetail();
                $tAdOrderDetail->order_id = $tAdOrder->id;
                $tAdOrderDetail->product_id = $product['pid'];
                $tAdOrderDetail->quantity = $product['q'];
                $tAdOrderDetail->total_coin = $product['coin'];
                $tAdOrderDetail->total_cash = $product['cash'];
                if (array_key_exists('value', $product) == true) {
                    $tAdOrderDetail->note = json_encode($product['value']);
                } else {
                    $tAdOrderDetail->note = '';
                }
                $tAdOrderDetail->save();
            }
        });
        Log::channel('customerlog')->info('T_AD_Order Model', [
            'end customerOrder'
        ]);
    }
}
