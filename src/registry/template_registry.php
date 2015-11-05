<?php

namespace ActionController\Registry;

class TemplateRegistry
{

  protected $map;
  
  public function __construct( $map = array() )
  {
    foreach ($map as $name => $spec) 
    {
      $this->set($name, $spec);
    }
  }
  
  public function set( $name, $spec )
  {
    if (is_string($spec)) 
    {
      $__FILE__ = $spec;
      $spec = function ($__VARS__ = array()) use ($__FILE__) 
      {
        extract($__VARS__, EXTR_SKIP);
    
        if(!file_exists($__FILE__))
        {
          throw new \ActionController\Exception\TemplateNotFound('Unable to load view: '.$__FILE__);
        }
    
        require $__FILE__;
      };
    }
    $this->map[$name] = $spec;
  }
  
  public function has( $name )
  {
    return isset($this->map[$name]);
  }
  
  public function get( $name )
  {
    if(isset($this->map[$name]))
    {
      return $this->map[$name];
    }
    throw new \ActionController\Exception\TemplateNotFound($name);
  }
}