<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\FuncCall;
use SebastianBergmann\Environment\Console;
use App\Common\Method;

class T_CU_Customer extends Model
{
  public $table = 't_cu_customer';
  use HasFactory;

  /*
      * Create : Zar Ni(15/1/2022)
      * Update :
      * Explain of function : To get data for DashboardCustomerMiniList
      * Prarameter : no
      * return :
    */
  public function DashboardMinicus()
  {

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start DashboardMinicus'
    ]);
    $dashboardcus = T_CU_Customer::limit(5)
      ->where('del_flg', 0)
      ->get();

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End DashboardMinicus'
    ]);

    return $dashboardcus;
  }
  /*
      * Create : Zar Ni(15/1/2022)
      * Update :
      * Explain of function : To get data for DashboardCuctomerCount
      * Prarameter : no
      * return :
    */
  public function Dashboardcuscount()
  {

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start Dashboardcuscount'
    ]);

    $cuscount = T_CU_Customer::where('t_cu_customer.del_flg', 0)
      ->count('t_cu_customer.id');

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End Dashboardcuscount'
    ]);

    return $cuscount;
  }
  /*
      * Create : Zar Ni(15/1/2022)
      * Update :
      * Explain of function : To get data for DashboardCuctomerCount
      * Prarameter : no
      * return :
    */
  public function customerInfoList()
  {

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start customerInfoList'
    ]);

    $customerlist = T_CU_Customer::select('*', DB::raw('t_cu_customer.id AS id'))
      ->leftjoin('m_state', 'm_state.id', '=', 't_cu_customer.address1')
      ->leftjoin('m_township', 'm_township.id', '=', 't_cu_customer.address2')
      ->where('t_cu_customer.del_flg', 0)
      ->orderBy('t_cu_customer.created_at', 'desc')
      ->paginate(10);

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End customerInfoList'
    ]);

    return $customerlist;
  }

  /*
      * Create : Zar Ni(20/1/2022)
      * Update :
      * Explain of function : To show customer search names
      * Prarameter : no
      * return :
    */
  public function cusSearch($request)
  {

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start cusSearch'
    ]);

    $cusSearch = T_CU_Customer::where('nickname', 'Like', '%' . $request->input('nickname') . '%')
      ->where('t_cu_customer.del_flg', 0)
      ->get();

    return $cusSearch;

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End cusSearch'
    ]);
  }
  /*
      * Create : zayar(03/2/2022)
      * Update :
      * Explain of function : To show customer search detail
      * Prarameter : no
      * return :
    */
  public function cusDetailSearch($sessionCustomerId)
  {

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start cusDetailSearch'
    ]);

    $cusSearch = T_CU_Customer::where('id', $sessionCustomerId)
      ->where('t_cu_customer.del_flg', 0)
      ->get();

    return $cusSearch;

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End cusDetailSearch'
    ]);
  }
  /*
      * Create : Zar Ni(20/1/2022)
      * Update :
      * Explain of function : To show customer id search
      * Prarameter : no
      * return :
    */
  public function cusidSearch($request)
  {

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start cusidSearch'
    ]);

    $cusidSearch = T_CU_Customer::where('customerID', 'Like', '%' . $request->input('id') . '%')
      ->where('t_cu_customer.del_flg', 0)
      ->get();

    return $cusidSearch;

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End cusidSearch'
    ]);
  }
  /*
      * Create : Zar Ni(20/1/2022)
      * Update :
      * Explain of function : To show customer id search
      * Prarameter : no
      * return :
    */
  public function customerDetail($id)
  {

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start customerDetail'
    ]);

    $cusDetail = T_CU_Customer::select('*', DB::raw('t_cu_customer.id AS id'))
      ->leftjoin('m_state', 'm_state.id', '=', 't_cu_customer.address1')
      ->leftjoin('m_township', 'm_township.id', '=', 't_cu_customer.address2')
      ->where('t_cu_customer.del_flg', 0)
      ->where('t_cu_customer.id', '=', $id)
      ->first();
    // Log::critical('asdasd',[$cusDetail]);
    return $cusDetail;

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End customerDetail'
    ]);
  }
  /*
      * Create : Zar Ni(20/1/2022)
      * Update :
      * Explain of function : get nickname for sending email.
      * Prarameter : no
      * return :
    */
  public function suggestmailnickname($id)
  {
    $sugmail = T_CU_Customer::select('nickname')
      ->where('id', $id)
      ->first();
    return $sugmail;
  }


  /*
      * Create : Min Khant(15/1/2022)
      * Update :
      * Explain of function : To store input data  from Register page
      * Prarameter : no
      * return :
    */
  public  function customerData($data, $key)
  {
    Log::channel('customerlog')->info('T_CU_Customer Model', [
      'start customerData'
    ]);

    //for generate customer id
    $firstStr = substr($data['username'], 0, 1);
    $lastStr = substr($data['username'], -1);
    $firstemail = substr($data['email'], 0, 1);
    $firstPwd = substr($data['password'], 0, 1);
    $lastPwd = substr($data['password'], -1);
    $day = date('d');
    $hour = date('h');

    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!#$%&';
    $generateKey = '';
    for ($i = 0; $i < 3; $i++) {
      $charLength = rand(0, strlen($characters) - 1);
      $generateKey .= $characters[$charLength];
    }

    $customerId = $firstStr . $lastStr . $firstemail . $firstPwd . $lastPwd . $day . $hour . $generateKey;

    $customercoin = new Method();
    $coin = $customercoin->customerCoin();

    DB::transaction(function () use ($customerId, $data, $key, $coin) {
      //insert customer
      $customer = new T_CU_Customer();
      $customer->customerID = $customerId;
      $customer->nickname = $data['username'];
      $customer->phone = $data['phone'];
      $customer->address1 = $data['addressState'];
      $customer->address2 = $data['addressTownship'];
      $customer->address3 = $data['addressNo'];
      $customer->fav_type = $data['type'] ? $data['type'] : '';
      $customer->taste = $data['taste'] ? $data['taste'] : '';
      $customer->allergic = $data['note'] ? $data['note'] : '';
      $customer->save();

      //insert customerLogin
      $customerLogin = new M_CU_Customer_Login();
      $customerLogin->email = $data['email'];
      $customerLogin->password = md5(sha1($data['password']));
      $customerLogin->customer_id =  $customer->id;
      $customerLogin->verify_code = $key;
      $customerLogin->save();

      //insert customer coin
      $customerCoin = new T_CU_Coin_Customer();
      $customerCoin->customer_id = $customer->id;
      $customerCoin->remain_coin = $coin;
      $customerCoin->save();

      // $customer->customerLogin()->save($customerLogin);
    });

    Log::channel('customerlog')->info('T_CU_Customer Model', [
      'end customerData'
    ]);
    return true;
  }

  public function customerLogin()
  {
    return $this->hasOne('App\Models\M_CU_Customer_Login');
  }

  /*
      * Create : zayar(21/1/2022)
      * Update :
      * Explain of function : To store input data  from Register page
      * Prarameter : no
      * return :
    */
  public function loginUser($sessionCustomerId)
  {
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start loginUser'
    ]);
    Log::channel('adminlog')->info("ok", [
      $sessionCustomerId
    ]);
    $search = T_CU_Customer::join('m_cu_customer_login', 'm_cu_customer_login.customer_id', '=', 't_cu_customer.id')
      ->where('m_cu_customer_login.customer_id', '=', $sessionCustomerId)
      ->join('m_township', 'm_township.id', '=', 't_cu_customer.address2')
      ->join('m_state', 'm_state.id', '=', 't_cu_customer.address1')
      ->select(
        '*',
        DB::raw('t_cu_customer.id AS cid'),
        DB::raw('m_cu_customer_login.id AS lid'),
        DB::raw('m_township.id AS tid'),
        DB::raw('m_state.id AS sid')
      )
      // ->join('m_fav_type', 'm_fav_type.id', '=', 't_cu_customer.fav_type')
      // ->join('m_taste', 'm_taste.id', '=', 't_cu_customer.taste')
      ->first();
    if ($search === null) {
      Log::channel('adminlog')->info("T_CU_Customer Model", [
        'End loginUser'
      ]);
      return null;
    } else {
      Log::channel('adminlog')->info("T_CU_Customer Model", [
        'End loginUser'
      ]);
      Log::channel('adminlog')->info("T_found", [
        $search
      ]);
      return $search;
    }
  }
  /*
      * Create : zayar(21/1/2022)
      * Update :
      * Explain of function : To take old password
      * Prarameter : no
      * return :
    */
  public function oldPassword($id)
  {
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start oldPassword'
    ]);
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      $id
    ]);
    $admin = M_CU_Customer_Login::where('customer_id', '=', $id)
      ->where('del_flg', '=', 0)
      ->first();
    if ($admin == null) {
      abort(500);
    }
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End oldPassword'
    ]);
    return $admin->password;
  }
  /*
      * Create : zayar(21/1/2022)
      * Update :
      * Explain of function : To update password
      * Prarameter : no
      * return :
    */
  public function updatePassword($id, $validate)
  {
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start updatePassword'
    ]);
    $admin = T_CU_Customer_Login::where('customer_id', '=', $id)
      // ->join('m_cu_customer_login', 'm_cu_customer_login.customer_id', '=', 't_cu_customer.id')
      ->first();
    $admin->password = md5(sha1($validate['newpassword']));

    $admin->save();
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End updatePassword'
    ]);
  }
  /*
      * Create : zayar(21/1/2022)
      * Update :
      * Explain of function : To update user profile
      * Prarameter : no
      * return :
    */
  public function updateProfile($id, $validate)
  {
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start updateProfile'
    ]);
    $admin = T_CU_Customer_Login::where('customer_id', '=', $id)
      // ->join('m_cu_customer_login', 'm_cu_customer_login.customer_id', '=', 't_cu_customer.id')
      ->first();
    $admin->password = $validate['newpassword'];

    $admin->save();
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End updateProfile'
    ]);
  }

  /*
      * Create : zayar(04/2/2022)
      * Update :
      * Explain of function : To update user profile
      * Prarameter : no
      * return :
    */
  public function editProfile($validate, $id)
  {
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start editProfile'
    ]);
    Log::channel('adminlog')->info("dfser", [
      $validate['username'] . $id
    ]);
    $customer = T_CU_Customer::find($id);
    $customer->nickname = $validate['username'];
    $customer->bio = $validate['bio'];
    $customer->phone = $validate['phonenumber'];
    $customer->address1 = $validate['state'];
    $customer->address2 = $validate['township'];
    $customer->address3 = $validate['addressNumber'];
    $customer->fav_type = $validate['favtype'];
    $customer->taste = $validate['Taste'];
    $customer->allergic = $validate['Allergic'];


    $customer->save();
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End editProfile'
    ]);
  }
  /*
      * Create : Linn Ko(20/1/2022)
      * Update :
      * Explain of function : To show customer search names
      * Prarameter : no
      * return :
    */
  public function searchByID($id)
  {
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start searchByID'
    ]);

    $result = T_CU_Customer::where('customerID', $id)
      ->leftjoin('t_cu_coin_customer', 't_cu_coin_customer.customer_id', 't_cu_customer.id')
      ->where('t_cu_customer.del_flg', 0)
      ->first();

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End searchByID'
    ]);

    return $result;
  }

  /*
      * Create : Linn Ko(20/1/2022)
      * Update :
      * Explain of function : To show customer search names
      * Prarameter : no
      * return :
    */
  public function searchByCustomerID($id)
  {
    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'Start searchByCustomerID'
    ]);

    $result = T_CU_Customer::where('customerID', $id)
      ->where('del_flg', 0)
      ->first();

    Log::channel('adminlog')->info("T_CU_Customer Model", [
      'End searchByCustomerID'
    ]);

    return $result;
  }

  /*
      * Create : Min Khant(28/1/2022)
      * Update :
      * Explain of function : To get customer info
      * Prarameter : no
      * return : customer info
    */
  public function customerInformation($id)
  {
    Log::channel('customerlog')->info("T_CU_Customer Model", [
      'Start customerInformation'
    ]);

    $result = T_CU_Customer::where('id', $id)
      ->where('del_flg', 0)
      ->get();

    Log::channel('customerlog')->info("T_CU_Customer Model", [
      'End customerInformation'
    ]);

    return $result;
  }



  /*
      * Create : Min Khant(29/1/2022)
      * Update :
      * Explain of function : To get Customer's township
      * Prarameter : customer id
      * return : township
    */
  public function deliveryTownship($id)
  {
    Log::channel('customerlog')->info("T_CU_Customer Model", [
      'Start deliveryTownship'
    ]);

    $township = T_CU_Customer::select('address2')
      ->where('id', $id)
      ->first();

    Log::channel('customerlog')->info("T_CU_Customer Model", [
      'End deliveryTownship'
    ]);
    return $township;
  }
  /*
    * Create : Cherry(30/1/2022)
    * Update :
    * Explain of function : To get state and township
    * Prarameter : $userID
    * return : deliTownship
    */

  public function deliTownship($userID)
  {

    Log::channel('adminlog')->info("T_CU_Customer", [
      'Start deliTownship'
    ]);

    $deliInfo = T_CU_Customer::select('*', DB::raw('t_cu_customer.id'))
      ->where('t_cu_customer.id', '=', $userID)
      ->join('m_township', 'm_township.id', '=', 't_cu_customer.address2')
      ->join('m_state', 'm_state.id', '=', 't_cu_customer.address1')
      ->first();

    Log::channel('adminlog')->info("T_CU_Customer", [
      'end deliTownship'
    ]);
    return $deliInfo;
  }
}
