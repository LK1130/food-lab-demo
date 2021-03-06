<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordValidation;
use App\Models\T_CU_Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerProfileUpdate extends Controller
{



    public function update(UpdatePasswordValidation $request, $id)
    {
        Log::channel('adminlog')->info("CustomerProfileUpdate", [
            'Start update'
        ]);
        $admin = new T_CU_Customer();
        $oldPassword = $admin->oldPassword($id);
        $validate = $request->validated();
        Log::channel('adminlog')->info("old", [
            $oldPassword
        ]);
        if ($oldPassword == md5(sha1($validate['oldpassword']))) {
            $admin = new T_CU_Customer();
            $admin->updatePassword($id, $validate);
            Log::channel('adminlog')->info("CustomerProfileUpdate", [
                'End update'
            ]);



            return redirect('editprofile');
        } else {
            Log::channel('adminlog')->info("CustomerProfileUpdate", [
                'End update(error)'
            ]);
            return redirect()->back()->with('error', 'Wrong Old Password');
        }
    }
}
