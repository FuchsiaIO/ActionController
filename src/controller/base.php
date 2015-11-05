<?php

namespace ActionController\Controller;

abstract class Base implements iAbstractController
{
  public $view = null;
  public $render;
  public static $before_filter = array();
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
    if(is_null($this->render))
    {
      $this->render = new \ActionController\Response\Render;
    }
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
  
  public function loadViewRegistries()
  {
    if(is_null($this->view))
    {
      $register = \ActionController\Registry\Register::getInstance();
      $this->view = (new \ActionController\Factory\ViewFactory)->newInstance();
      $this->view->setRegistries(
        new \ActionController\Registry\TemplateRegistry($register->viewMap),
        new \ActionCOntroller\Registry\TemplateRegistry($register->templateMap)
      );
    }
    return $this->view;
  }
  
  public function render( $name, $data = array() )
  {
    if(is_null($this->view))
    {
      $this->loadViewRegistries();
    }
    $this->view->setView($name);
    echo $this->view->__invoke($data);
  }
  
  public function filter( $action, $type = 'Before', $namespace = '\\ActionController\\Filter\\')
  {
    $filter_data = null;
    switch($type)
    {
      case 'Before':
        $filter_data = $this::$before_filter;
        break;
      default:
        
    }
    $results = \ActionController\Filter\FilterFactory::newInstance($type,$namespace)->filter(
      $action, $filter_data
    );

    $this->execute_filter_actions($results);
    
  }
  
  public function getFilter( $filter_type )
  {
    switch($filter_type)
    {
      case 'Before':
        return $this::$before_filter;
      default:
        return null;
    }
  }
  
  protected function redirect_to( $url, $replace = true, $redirect_code = 301, $content_type = 'text/html')
  {
    header('Content-Type: '.$content_type);
    header('Location: '.$url, $replace, $redirect_code);
  }
  
  private function execute_filter_actions( $actions )
  {
    foreach($actions as $action)
    {
      $this->$action();
    }
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