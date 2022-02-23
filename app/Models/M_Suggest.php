<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class M_Suggest extends Model
{
    public $table = 'm_suggest';
    use HasFactory;

    /*
     * Create : Min Khant(22/1/2022)
     * Update :
     * Explain of function : to get suggest type from database
     * Prarameter : no
     * return : suggest type
     * */
    public function suggestType()
    {
        Log::channel('customerlog')->info('M_Suggest Model', [
            'start suggestType'
        ]);
        $type = M_Suggest::select(['id', 'suggest_type'])
            ->where('del_flg', 0)
            ->get();

        Log::channel('customerlog')->info('M_Suggest Model', [
            'end suggestType'
        ]);
        return $type;
    }
    /*
    * Create:zayar(2022/01/15) 
    * Update: 
    * This function is used to store suggest.
    */

    public function suggestAdd($validate)
    {
        Log::channel('adminlog')->info("M_Suggest Model", [
            'Start suggestAdd'
        ]);
        $admin = new M_Suggest();
        $admin->suggest_type = $validate['suggest_type'];
        $admin->note = $validate['note'];
        $admin->save();
        Log::channel('adminlog')->info("M_Suggest Model", [
            'End suggestAdd'
        ]);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to show suggest edit view.
   */

    public function suggestEditView($id)
    {
        Log::channel('adminlog')->info("M_Suggest Model", [
            'Start suggestEditView'
        ]);
        Log::channel('adminlog')->info("M_Suggest Model", [
            'End suggestEditView'
        ]);
        return M_Suggest::find($id);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to update suggest.
   */

    public function suggestEdit($validate, $id)
    {
        Log::channel('adminlog')->info("M_Suggest Model", [
            'Start suggestEdit'
        ]);
        $admin = M_Suggest::find($id);
        $admin->suggest_type = $validate['suggest_type'];
        $admin->note = $validate['note'];
        $admin->save();
        Log::channel('adminlog')->info("M_Suggest Model", [
            'End suggestEdit'
        ]);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to update del_flg to 1.
   */
    public function suggestDelete($id)
    {
        Log::channel('adminlog')->info("M_Suggest Model", [
            'Start suggestDelete'
        ]);
        $admin = M_Suggest::find($id);
        $admin->del_flg = 1;
        $admin->save();
        Log::channel('adminlog')->info("M_Suggest Model", [
            'End suggestDelete'
        ]);
    }
}
