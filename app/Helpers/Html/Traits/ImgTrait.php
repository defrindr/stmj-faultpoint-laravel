<?php
namespace App\Helpers\Html\Traits;

Trait ImgTrait {

	// to handle template
	public static $template;
	public static $options;
	public static $label;

	public static function img($src,$options = []) {
		self::$options = array_replace([
			'class' => '',
			'style' => ''
		], $options);

		self::$options['src'] = $src;

		self::$tagName = 'img';

		return new self;

	}
}