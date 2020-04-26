<?php
namespace App\Helpers;


class LaraYii {
	

	public static function alert($errors){
		$template = "";
		
		if($errors->any()){

			$template .= "<div class='alert alert-danger alert-dismissible'>";
			$template .= "	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
			$template .= "	<h5><i class='icon fas fa-ban'></i> ". __("Terjadi Kesalahan Ketika Melakukan Validasi"). " </h5>";
			$template .= "	<ul>";
			foreach($errors->all() as $row){
				$template .= "	  <li>";
				$template .= "	   	$row <br>";
				$template .= "	  </li>";
			}
			$template .= "	</ul>";
			$template .= "</div>";
		}

		if(session()->has('error')){
			$error = session('error');


			$template .= "<div class='alert alert-danger alert-dismissible'>";
			$template .= "	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
			$template .= "	<ul  style='list-style-type: none;margin:0;padding:0'>";
			$template .= "	  <li>";
			$template .= "		<i class='icon fas fa-ban'></i> ". __($error). " </h5>";
			$template .= "	   	 <br>";
			$template .= "	  </li>";
			$template .= "	</ul>";
			$template .= "</div>";
		}

		if(session()->has('success')){
			$success = session('success');


			$template .= "<div class='alert alert-success alert-dismissible'>";
			$template .= "	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
			$template .= "	<ul style='list-style-type: none;margin:0;padding:0'>";
			$template .= "	  <li>";
			$template .= "	   	$success <br>";
			$template .= "	  </li>";
			$template .= "	</ul>";
			$template .= "</div>";
		}

			return $template;
	}
	
}