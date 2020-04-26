<?php
namespace App\Helpers;

class ArrayHelper {

	public static function map($arrmap,$schemas = []){
		if($schemas == []){
			throw new Exception("$schemas must be valuable", 1);
		} else {
			try{
				$newArray = [];
				foreach ($arrmap as $handledata) {
					if(count($schemas) > 1){
						foreach ($schemas as $row) {
							$templateArr = [];

							foreach ($row as $key => $value) {
								$templateArr += [ $arrmap[$key] => $arrmap[$value] ];
							}

							$newArray += $templateArr;

						}
					}else {
						foreach ($schemas as $key => $value) {
							$newArray += [ $handledata[$key] => $handledata[$value] ];
						}					
					}
				}

				return $newArray;
			}catch(Exception $e){
				throw new Exception("Error : ". $e , 1);
			}
		}
	}

}