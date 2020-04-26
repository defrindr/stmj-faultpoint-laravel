<?php
namespace App\Helpers;

use App\Helpers\Traits\GridviewTrait;

class GridViewHelper {

	use GridviewTrait;

	public static function get(){
		self::build();

		return self::$template;
	}

}