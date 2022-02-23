<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class M_Fav_Type extends Model
{
  public $table = 'm_fav_type';
  use HasFactory;
  /*
    * Create:zayar(2022/01/15) 
    * Update: 
    * This function is used to store Favourite Type.
    */

  public function favTypeAdd($validate)
  {
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'Start favTypeAdd'
    ]);
    $admin = new M_Fav_Type();
    $admin->favourite_food = $validate['favourite_food'];
    $admin->note = $validate['note'];
    $admin->save();
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'End favTypeAdd'
    ]);
  }
  /*
  * Create:zayar(2022/01/15) 
  * Update: 
  * This function is used to show Favourite Type edit view.
  */

  public function favTypeEditView($id)
  {
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'Start favTypeEditView'
    ]);
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'End favTypeEditView'
    ]);
    return M_Fav_Type::find($id);
  }
  /*
  * Create:zayar(2022/01/15) 
  * Update: 
  * This function is used to update Favourite Type.
  */

  public function favTypeEdit($validate, $id)
  {
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'Start favTypeEdit'
    ]);
    $admin = M_Fav_Type::find($id);
    $admin->favourite_food = $validate['favourite_food'];
    $admin->note = $validate['note'];
    $admin->save();
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'End favTypeEdit'
    ]);
  }
  /*
  * Create:zayar(2022/01/15) 
  * Update: 
  * This function is used to update del_flg to 1.
  */
  public function favTypeDelete($id)
  {
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'Start favTypeDelete'
    ]);
    $admin = M_Fav_Type::find($id);
    $admin->del_flg = 1;
    $admin->save();
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'End favTypeDelete'
    ]);
  }
  /*
   * Create:zayar(2022/01/15) 
   * Update: 
   * This function is used to get all favourite type.
   */

  public function allType()
  {
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'Start allType'
    ]);
    return M_Fav_Type::where('del_flg', '=', 0)->get();
    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'End allType'
    ]);
  }

  /*
    * Create : Aung Min Khant(20/1/2022)
    * Update :
    * Explain of function : To get  all data from m_taste 
    * parament : none
    * return get data
    * */
  public function getTypeAll()
  {

    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'Start all Data'
    ]);
    $mType = M_Fav_Type::all();

    Log::channel('adminlog')->info("M_Fav_Type Model", [
      'End all Data'
    ]);
    return  $mType;
  }

  /*
     * Create : Min Khant(24/1/2022)
     * Update :
     * Explain of function : to get fav type data
     * Prarameter : no
     * return : fav type
     * */
  public function type()
  {
    Log::channel('customerlog')->info('M_Fav_Type Modal', [
      'start type'
    ]);

    $typenames = M_Fav_Type::where('del_flg', 0)->get();

    Log::channel('customerlog')->info('M_Fav_Type Modal', [
      'end type'
    ]);
    return $typenames;
  }

  /*
     * Create : Min Khant(1/2/2022)
     * Update :
     * Explain of function : to get customer fav type id
     * Prarameter : no
     * return : fav type id
     * */
  public function customerFavType($type)
  {
    Log::channel('customerlog')->info('M_Fav_Type Modal', [
      'start type'
    ]);

    $typeId = M_Fav_Type::select('id')
      ->where('favourite_food', $type)
      ->where('del_flg', 0)
      ->first();

    Log::channel('customerlog')->info('M_Fav_Type Modal', [
      'end type'
    ]);
    return $typeId;
  }


  public function tagsType()
  {

    Log::channel('customerlog')->info('M_Fav_Type Modal', [
      'start tagsType'
    ]);
    $types = M_Fav_Type::all()->pluck('favourite_food')->toArray();
    Log::channel('customerlog')->info('gggggggg', []);
    Log::channel('customerlog')->info('M_Fav_Type Modal', [
      'start tagsType'
    ]);
    return $types;
  }
}
