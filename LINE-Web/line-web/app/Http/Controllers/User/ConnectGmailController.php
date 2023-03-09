<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ConnectGmailController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
      
            $user = Socialite::driver('google')->stateless()->user();
            

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            date_default_timezone_get();    
            $count = DB::table('tb_user_info')->where(['userId' =>  $user['id']])->get();
            if(count($count)==0)
            {
                $resultInsert_connect_line= DB::table('tb_connect_line')->
                insert([
                    'userId'=>$user->id,
                    'status'=>'connect to gmail',
                    'date'=>date('Y/m/d H:i:s'),
                ]);

                $resultInsert_user_info = DB::table('tb_user_info')->
                insert([
                    'userId'=>$user->id,
                    'displayName'=>$user->name,
                    'pictureUrl'=>$user->avatar,
                    'email'=>$user->email
                ]);


            }
            else
            {
                $dataUpdateGmail = DB::table('tb_user_info')
                ->where(['userId' =>  $user['id']])
                ->update([
                    'displayName'=>$user->name,
                    'pictureUrl'=>$user->avatar,
                    'email'=>$user->email
                ]);
            }
            $profile = DB::table('tb_user_info')->where(['userId' =>  $user['id']])->get()[0];
            $profile= json_decode(json_encode($profile), true);
            $request->session()->put('inforUser', $profile);      
        } catch (Exception $e) {
            // $user = Socialite::driver($provider)->stateless()->user();
        }

        
        return Redirect::to('/user');
    }

}
