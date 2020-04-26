<?php
namespace App\Helpers\Html\Traits;


Trait SidebarTrait {
	protected static function sidebarTemplate($data){
		$sidebarMockup = "";
		if(isset($data["children"]) && $data["children"] != []){
	        $sidebarMockup .= '
	        	<li class="nav-item has-treeview">
	            	<a href="'.$data["link"].'" class="nav-link">
	            		<i class="nav-icon '.$data["icon"].'"></i>
	            		<p>
	                		'.$data["title"].'
	                		<i class="right fas fa-angle-left"></i>
	            		</p>
	            	</a>
	            <ul class="nav nav-treeview">';
	        $sidebarMockup .= self::mockingSidebar($data["children"]);
	        $sidebarMockup .= '
	            </ul>
	        </li>';
		}else{
	        $sidebarMockup .= '
	        <li class="nav-item">
	            <a href="'.$data["link"].'" class="nav-link">
					<i class="'.$data["icon"].' nav-icon"></i>
					<p>'.$data["title"].'</p>
	            </a>
			</li>';
	    }

	    return $sidebarMockup;
	}

	protected static function mockingSidebar($arr){

		$sidebarMockup = "";
	    foreach($arr as $data){
	    	if(isset($data['role']) && $data['role'] != ""){
				$roles = \Auth::user()->role;
				$dataRole = explode("|",$data['role']);
				$isRolePassed = false;
				// cari apakah user mempunyai role yang telah ditetapkan
				foreach($dataRole as $dRole){
					foreach($roles as $role){
						if(strtolower($role->role->nama) == strtolower($dRole)){
							$isRolePassed = true;
						}
					}
				}
				if($isRolePassed){
					$sidebarMockup .= self::sidebarTemplate($data);
				}

	    	}else{
	    		$sidebarMockup .= self::sidebarTemplate($data);
	    	}
	    }

		return $sidebarMockup;
	}


	public static function generateSidebar($arr){
		$mockup = "";
		$mockup .= self::mockingSidebar($arr);
		return $mockup;
	}
}