<?php
namespace App\Helpers\Html\Traits;


Trait ATrait {
	
	public static function a($link,$options = []) {
		self::$options = array_replace([
			'class' => '',
			'style' => ''
		], $options);

		self::$options['href'] = $link;

		self::$tagName = 'a';

		return new self;

	}

}