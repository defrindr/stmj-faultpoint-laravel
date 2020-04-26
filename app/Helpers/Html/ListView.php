<?php
namespace App\Helpers\Html;

use App\Helpers\Html\Traits\BaseTrait;

class ListViewHelper {

  private static $template;
  private static $options;
  private static $data;
  private static $without;


  public static function build(){
    self::$template = '<table ';
    self::renderOptions();

    self::$template .= '> ';
    if(is_array(self::$data)){
    	self::renderDataAsArray();
    }else{
      self::renderDataAsObject();
    }

    self::$template .= ' </table>';

  }




  public static function renderOptions(){
    if(isset(self::$options) && self::$options != []){
      foreach (self::$options as $key => $value) {
        self::$template .= $key . "='" . $value. "'";
      }
    }
    return new self;
  }





  public static function renderDataAsObject(){
    if(isset(self::$data) && self::$data != []){
      $attr = array_keys(self::$data->getAttributes());
      
      // removing attributes filtered
      foreach (self::$without as $i) {
        unset($attr[array_search($i,$attr)]); 
      }
      


      foreach ($attr as $i) {
        self::$template .= "<tr>";
        self::$template .= "<td>". ucwords(str_replace('_',' ',$i)) ."</td><td> : </td><td>". self::$data[$i] ."</td>";
        self::$template .= "</tr>";
      }
    }
    return new self;
  }







  public static function renderDataAsArray(){
    if(isset(self::$data) && self::$data != []){

      // removing attributes filtered
      foreach (self::$without as $i) {
        unset(self::$data[$i]); 
      }
      


      foreach (self::$data as $key => $val) {
        self::$template .= "<tr>";
        self::$template .= "<td>". ucwords(str_replace('_',' ',$key)) ."</td><td> : </td><td>". ucwords($val) ."</td>";
        self::$template .= "</tr>";
      }
    }
    return new self;
  }





  public static function generate($data,$without=[],$options = []){
    // default value
    self::$options = array_replace([], $options);
    self::$data = $data;
    self::$without = $without;
    

    self::build();

    return self::$template;
  }

}