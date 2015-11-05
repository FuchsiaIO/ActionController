<?php

namespace ActionController\Registry;

class Register 
{
  
  private static $instance;
  private $attachments = array();
  
  public static function getInstance()
  {
    if (!isset(self::$instance)) 
    {
      self::$instance = new \ActionController\Registry\Register();
    }
    return self::$instance;
  }
  
  public function attach( $element, $alias)
  {
    $this->attachments[$alias] = $element;
  }
  
  public function __get( $element )
  {
    if( array_key_exists($element, $this->attachments) )
      return $this->attachments[$element];
    return null;
  }
  
}