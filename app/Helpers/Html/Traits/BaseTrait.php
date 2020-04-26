<?php

namespace App\Helpers\Html\Traits;

Trait BaseTrait {

	public static $template;

	public static $tagName;



	public static $attributes = [
		'id',
		'class',
		'src',
		'for',
		'style',
		'href',
		'lang',
		'content',
		'name',
		'autocomplete',
		'placeholder',
		'width',
		'height',
		'maxlength',
		'minlength',
		'enctype',
		'method',
	];


	// syntax tanpa tutup 
	public static $singleTag = [
		'img' => 1,
		'link' => 1,
		'hr' => 1,
		'span' => 1,
		'br' => 1,
		'embed' => 1,
		'base' => 1,
		'input' => 1,
		'keygen' => 1,
		'meta' => 1,
		'param' => 1,
		'source' => 1,
		'track' => 1,
		'wbr' => 1,
	];


	public static function tag(){
		self::$template = "<". self::$tagName ." ";

		self::renderAttributtes();

		self::$template .= ((!isset(self::$singleTag[self::$tagName])) ? 0 : self::$singleTag[self::$tagName] ) ? ">" : (isset(self::$label) && self::$label !== null) ?  ">".self::$label ."</". self::$tagName .">" : "></". self::$tagName .">";

		return new self;
	}


	public static function renderAttributtes(){
		foreach (self::$options as $key => $value) {
			if($value !== "") self::$template .= $key .'="'. $value .'" ';
		}
		return new self;
	}

	public static function label($label) {
		self::$label = $label;

		return new self;
	}

	public static function get() {
		self::tag();

		return self::$template;
	}
}