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
}