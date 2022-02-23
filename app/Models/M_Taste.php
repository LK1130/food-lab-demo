<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class M_Taste extends Model
{
    use HasFactory;
    public $table = 'm_taste';
    /*
    * Create:zayar(2022/01/15) 
    * Update: 
    * This function is used to store taste.
    */

    public function tasteAdd($validate)
    {
        Log::channel('adminlog')->info("M_Taste Model", [
            'Start tasteAdd'
        ]);
        $admin = new M_Taste();
        $admin->taste = $validate['taste'];
        $admin->note = $validate['note'];
        $admin->save();
        Log::channel('adminlog')->info("M_Taste Model", [
            'End tasteAdd'
        ]);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to show taste edit view.
   */

    public function tasteEditView($id)
    {
        Log::channel('adminlog')->info("M_Taste Model", [
            'Start tasteEditView'
        ]);
        Log::channel('adminlog')->info("M_Taste Model", [
            'End tasteEditView'
        ]);
        return M_Taste::find($id);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to update taste.
   */

    public function tasteEdit($validate, $id)
    {
        Log::channel('adminlog')->info("M_Taste Model", [
            'Start tasteEdit'
        ]);
        $admin = M_Taste::find($id);
        $admin->taste = $validate['taste'];
        $admin->note = $validate['note'];
        $admin->save();
        Log::channel('adminlog')->info("M_Taste Model", [
            'End tasteEdit'
        ]);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to update del_flg to 1.
   */
    public function tasteDelete($id)
    {
        Log::channel('adminlog')->info("M_Taste Model", [
            'Start tasteDelete'
        ]);
        $admin = M_Taste::find($id);
        $admin->del_flg = 1;
        $admin->save();
        Log::channel('adminlog')->info("M_Taste Model", [
            'End tasteDelete'
        ]);
    }
    /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to get all taste.
   */

    public function allTastes()
    {
        Log::channel('adminlog')->info("M_Taste Model", [
            'Start allTastes'
        ]);
        Log::channel('adminlog')->info("M_Taste Model", [
            'End allTastes'
        ]);
        return M_Taste::where('del_flg', '=', 0)->get();
    }


    /*
    * Create : Aung Min Khant(20/1/2022)
    * Update :
    * Explain of function : To get  all data from m_taste 
    * parament : none
    * return get data
    * */
    public function getTasteAll()
    {

        Log::channel('adminlog')->info("M_Taste Model", [
            'Start all Data'
        ]);
        $mTaste = M_Taste::all();

        Log::channel('adminlog')->info("M_Taste Model", [
            'End all Data'
        ]);
        return  $mTaste;
    }


    public function taste()
    {
        Log::channel('customerlog')->info('M_Taste Modal', [
            'start taste'
        ]);

        $tastenames = M_Taste::where('del_flg', 0)->get();

        Log::channel('customerlog')->info('M_Taste Modal', [
            'end taste'
        ]);
        return $tastenames;
    }
}
