<?php

namespace ActionController\Controller;

abstract class Base implements iAbstractController
{
  public $view = null;
  public $render;
  protected $data = array();
  
  public function __construct(){}
  
  public function respondTo(callable $lambda)
  {
    call_user_func($lambda, $this->getRenderer());
  }
  
  public function canRespondTo($type = '.html')
  {
    $type = str_replace('.', '', $type);
    return $this->render->$type ? true : false;
  }
  
  public function getData()
  {
    return $this->data;
  }
  
  public function &getRenderer()
  {
    return $this->render;
  }

  public function __call( $method, array $arguments)
  {
    if(is_null($this->view))
    {
      $this->view = (new \ActionController\Factory\ViewFactory)->newInstance();
    }
    $this->view->$method($arguments[0] ? $arguments : false);
  }
  
  public function __set( $name, $value)
  {
    $this->data[$name] = $value;
  }
  
  public function __get( $name )
  {
    if( array_key_exists($name, $this->data) )
      return $this->data[$name];
    else
      throw new \ActionController\Exception\UndefinedProperty;
  }
}