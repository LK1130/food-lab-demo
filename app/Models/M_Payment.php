<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class M_Payment extends Model
{
    public $table = 'm_payment';
    use HasFactory;
    /*
    * Create:zayar(2022/01/15) 
    * Update: 
    * This function is used to store payment.
    */

    public function getPayment()
    {
        Log::channel('adminlog')->info("M_Payment Model", [
            'Start getPayment'
        ]);
        Log::channel('adminlog')->info("M_Payment Model", [
            'End getPayment'
        ]);
        return M_Payment::all();
    }

    /*
    * Create:zayar(2022/01/15) 
    * Update: 
    * This function is used to store payment.
    */

    public function paymentAdd($validate)
    {
        Log::channel('adminlog')->info("M_Payment Model", [
            'Start paymentAdd'
        ]);
        $admin = new M_Payment();
        $admin->payment_name = $validate['payment_name'];
        $admin->account_name = $validate['accountname'];
        $admin->note = $validate['note'];
        $admin->save();
        Log::channel('adminlog')->info("M_Payment Model", [
            'End paymentAdd'
        ]);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to show payment edit view.
   */

    public function paymentEditView($id)
    {
        Log::channel('adminlog')->info("M_Payment Model", [
            'Start paymentEditView'
        ]);
        Log::channel('adminlog')->info("M_Payment Model", [
            'End paymentEditView'
        ]);
        return M_Payment::find($id);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to update payment.
   */
    public function paymentEdit($validate, $id)
    {
        Log::channel('adminlog')->info("M_Payment Model", [
            'Start paymentEdit'
        ]);
        $admin = M_Payment::find($id);
        $admin->payment_name = $validate['payment_name'];
        $admin->account_name = $validate['accountname'];
        $admin->note = $validate['note'];
        $admin->save();
        Log::channel('adminlog')->info("M_Payment Model", [
            'End paymentEdit'
        ]);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to update del_flg to 1.
   */
    public function paymentDelete($id)
    {
        Log::channel('adminlog')->info("M_Payment Model", [
            'Start paymentDelete'
        ]);
        $admin = M_Payment::find($id);
        $admin->del_flg = 1;
        $admin->save();
        Log::channel('adminlog')->info("M_Payment Model", [
            'End paymentDelete'
        ]);
    }
 /*
   * Create:Zaw Phyo (2022/01/28) 
   * Update: 
   * This function is used to pull out Payment Accounts.
   * Return : Payment Accounts.
   */
    public function paymentAcoounts(){
        Log::channel('adminlog')->info("M_Payment Model", [
            'Start paymentAccounts'
        ]);

        $paymentAccounts = M_Payment::where('del_flg',0)->get();
        return $paymentAccounts;
    }
}
