<?php

namespace ActionController\Response;

class Render
{
  protected $data;
  
  public function __construct($formats = array( 
    ".html" => false,
    ".xml"  => false,
    ".json" => false 
  ))
  {
    $this->data = $formats;
  }
  
  public function getData()
  {
    return $this->data;
  }
  
  public function __set( $name, $value )
  {
    $this->data['.'.$name] = $value;
  }
  
  public function __get( $name )
  {
    if( array_key_exists('.'.$name, $this->data) )
      return $this->data['.'.$name];
    else
      return false;
  }
}