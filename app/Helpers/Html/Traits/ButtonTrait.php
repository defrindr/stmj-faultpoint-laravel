<?php
namespace App\Helpers\Html\Traits;


Trait ButtonTrait {
	

	// to handle template
	public static $template;
	public static $options;
	public static $label;

	public static function button($options = [],$buttonPrevent = true,$clicked = "return 0;") {
		self::$options = array_replace([
			'class' => '',
			'style' => ''
		], $options);

		if(!$buttonPrevent){
			self::$options["onclick"] = "event.preventDefault();".$clicked;
		}

		self::$tagName = 'button';

		return new self;

	}


	public static function submit($options = []) {
		self::$options = array_replace([
			'class' => '',
			'style' => ''
		], $options);
		self::$options["onclick"] = "return confirm('Apakah Anda Yakin ? ') ? true : false";

		self::$tagName = 'button';

		return new self;

	}


	public function disable(){
		self::$options += ["readonly" => "true"];

		return new self;
	}
}