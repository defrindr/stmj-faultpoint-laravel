<?php
namespace App\Helpers\Html;


class FormHelper {

	// template
	protected static $_instances = null;
	protected static $options = [];
	protected static $template = "";
	protected static $fieldTemplate = "";
	protected static $groupTemplate = "";
	private static $data;

	// name of form field
	protected static $name = "";
	protected static $model = "";
	protected static $label = "";
	protected static $typeField = "";


	public static function begin($setting = null){
		$setting = array_replace([
      		'id' => '',
      		'action' => '',
      		'method' => 'POST',
      		'options' => []
      	], $setting);

      	$setting['options'] = array_replace([
      			'class' => 'form',
      			'enctype' => '',
      		], $setting['options']);

      	$template = '<form id="' . $setting['id'] . '" ';

      	$template .= 'action="' . $setting['action'] . '" ';
      	$template .= 'method="' . ( ($setting['method'] == 'GET') ? 'GET' : 'POST') . '" ';


      	if(isset($setting['options']) & $setting['options'] != []){
	      	foreach ($setting['options'] as $key => $value) {
		      	$template .= $key. '="' . $value . '" ';
	      	}
      	}
      	
      	$template .= '>';

      	if(strtolower($setting['method']) != strtolower("GET") ){
      		$template .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
      		$template .= '<input type="hidden" name="_method" value="'.strtolower($setting['method']).'">';
      	}

      	if(self::$_instances=== null){
      		self::$_instances = new self;
      	}
      	self::$template = $template;

      	echo $template;

      	return self::$_instances;
	}

	public static function field($model=null,$names=""){
		self::$model = $model;

		self::$name = $names;

		if(self::$model != []){
			self::$options["value"] = self::$model[self::$name];
			self::$options["id"] = self::$name;
		}



		
		
	      	self::$groupTemplate = '<div class="form-group">';

	      	if(self::$label != '') {
		      	self::$groupTemplate .= '<label form="' . self::$name . '">' . self::$label . '</label>';	
	      	}

	      	if(self::$fieldTemplate != ""){
		
		      	self::$groupTemplate .= self::$fieldTemplate;
	    
	      	}
	    
	      	self::$groupTemplate .= '</div>';
		return new self;
	}

	public static function input($options = [],$onlynumber=false){
		self::$options += array_replace([
			'class' => 'form-control',
			'style' => '',
			'id' => '',
		], $options);

		if($onlynumber) self::$options['onkeyup'] = "this.value = this.value.replace(/[^\d]+/g,'')";

		self::$fieldTemplate = '<input type="text"';

		self::$fieldTemplate .= 'name="' . self::$name . '"';

		foreach (self::$options as $key => $val) {
			if($val != ''){
				self::$fieldTemplate .= $key.'="'.$val.'" ';
			}
		}

		self::$fieldTemplate .= ">";

		return new self;
	}




	public static function password($options = [],$onlynumber=false){
		self::$options += array_replace([
			'class' => 'form-control',
			'style' => '',
			'id' => '',
		], $options);

		if($onlynumber) self::$options['onkeyup'] = "this.value = this.value.replace(/[^\d]+/g,'')";

		self::$fieldTemplate = '<input type="password"';

		self::$fieldTemplate .= 'name="' . self::$name . '"';

		foreach (self::$options as $key => $val) {
			if($val != ''){
				self::$fieldTemplate .= $key.'="'.$val.'" ';
			}
		}

		self::$fieldTemplate .= ">";

		return new self;
	}





	public static function textarea($options = []){
		self::$options += array_replace([
			'class' => 'form-control',
			'style' => '',
			'id' => '',
		], $options);

		self::$fieldTemplate = '<textarea ';

		self::$fieldTemplate .= 'name="' . self::$name . '"';

		foreach (self::$options as $key => $val) {
			if($key == "value"){
				continue;
			}
			if($val != ''){
				self::$fieldTemplate .= $key.'="'.$val.'" ';
			}
		}

		self::$fieldTemplate .= ">";

		if( isset(self::$options['value']) && self::$options['value'] != '' ) self::$fieldTemplate .= self::$options['value'];
		
		self::$fieldTemplate .= '</textarea>';

		return new self;
	}


	public static function email($options = []){
		self::$options += array_replace([
			'class' => 'form-control',
			'style' => '',
			'id' => '',
		], $options);

		self::$fieldTemplate = '<input type="email"';

		self::$fieldTemplate .= 'name="' . self::$name . '"';

		foreach (self::$options as $key => $val) {
			if($val != ''){
				self::$fieldTemplate .= $key.'="'.$val.'" ';
			}
		}

		self::$fieldTemplate .= ">";

		return new self;
	}



	public static function date($options = []){
		self::$options = array_replace([
			'class' => 'form-control',
			'style' => '',
			'id' => '',
		], $options);

		if( (!isset(self::$options["value"]) || self::$options["value"] == "") && ( isset($options["value"]) && $options["value"] != "" ) ){
			self::$options["value"] = $options["value"];
		}

		self::$fieldTemplate = '<input type="date"';

		self::$fieldTemplate .= 'name="' . self::$name . '"';

		foreach (self::$options as $key => $val) {
			if($val != ''){
				self::$fieldTemplate .= $key.'="'.$val.'" ';
			}
		}

		self::$fieldTemplate .= ">";

		return new self;
	}





	public static function null(){
		if(isset(self::$options['value'])){
			unset(self::$options['value']);
		}
		return new self;
	} 





	public static function select($data= [],$options = []){
		self::$options += array_replace([
			'class' => 'form-control',
			'style' => '',
			'id' => '',
		], $options);

		self::$fieldTemplate = '<select ';

		self::$fieldTemplate .= 'name="' . self::$name . '"';

		foreach (self::$options as $key => $val) {
			if($val != '' && $key != "value"){
				self::$fieldTemplate .= $key.'="'.$val.'" ';
			}
		}

		self::$fieldTemplate .= ">";


		self::$fieldTemplate .= "<option value=''> -- Pilih Options --</option>";

		
		foreach ($data as $key => $val) {
			self::$fieldTemplate .= "<option value='" . $key. "' ";
			if(isset(self::$options['value'])){
				if(self::$options['value'] == $key){
					self::$fieldTemplate .=  'selected';
				}
			}
			self::$fieldTemplate .= " >". ucwords(str_replace('_',' ',$val)) ."</option>";
		}

		self::$fieldTemplate .= "</select>";



		return new self;
	}



	public static function number($options = []){
		self::$options += array_replace([
			'class' => 'form-control',
			'style' => '',
			'id' => '',
		], $options);

		if( (!isset(self::$options["value"]) || self::$options["value"] == "") && ( isset($options["value"]) && $options["value"] != "" ) ){
			self::$options["value"] = $options["value"];
		}


		self::$fieldTemplate = '<input type="number"';

		self::$fieldTemplate .= 'name="' . self::$name . '"';

		foreach (self::$options as $key => $val) {
			if($val != ''){
				self::$fieldTemplate .= $key.'="'.$val.'" ';
			}
		}

		self::$fieldTemplate .= ">";

		return new self;
	}




	public static function hidden($options = []){
		self::$options += array_replace([
			'class' => 'form-control',
			'style' => '',
			'id' => '',
		], $options);

		if( (!isset(self::$options["value"]) || self::$options["value"] == "") && ( isset($options["value"]) && $options["value"] != "" ) ){
			self::$options["value"] = $options["value"];
		}


		self::$fieldTemplate = '<input type="hidden"';

		self::$fieldTemplate .= 'name="' . self::$name . '"';

		foreach (self::$options as $key => $val) {
			if($val != ''){
				self::$fieldTemplate .= $key.'="'.$val.'" ';
			}
		}

		self::$fieldTemplate .= ">";

		return new self;
	}



	public static function label($label){
		
		self::$label = $label;

		return new self;

	}


	public static function get(){

		self::field(self::$model,self::$name);
		// template

		self::$options = [];
		self::$data = "";

		// name of form field
		self::$name = "";
		self::$model = "";
		self::$label = "";
		self::$typeField = "";

		return self::$groupTemplate;
	}


	public static function end(){
		$template = "</table>";
		echo $template;
	}

}