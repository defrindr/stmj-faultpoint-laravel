<?php
namespace App\Helpers\Auth;

class RolesValidation {

	public static function has($arr){
		$roles = \Auth::user()->role;
		$dataRole = explode("|",$arr);
		$isRolePassed = false;
		// cari apakah user mempunyai role yang telah ditetapkan
		foreach($dataRole as $dRole){
			foreach($roles as $role){
				if(strtolower($role->role->nama) == strtolower($dRole)){
					$isRolePassed = true;
				}
			}
		}
		return $isRolePassed;
	}

	public static function getId(){
		return auth()->user()->id;
	}


    public static function checkAuthorization($data){
        $authorization = false;
        if( self::has('Super Admin') ){
            $authorization = true;
        }else{
            if($data->user_id == self::getId()) $authorization = true;
        }

        return $authorization;
    }
}