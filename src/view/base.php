<?php

namespace ActionController\View;

abstract class Base
{
  
  private $data;
  private $content;
  private $layout;
  private $view;
  private $section;
  private $capture;
  private $template_registry;
  private $view_registry;
  private $layout_registry;
  
  public function __construct( $view_registry, $layout_registry) 
  {
    $this->data = (object) array();
    $this->view_registry = $view_registry;
    $this->layout_registry = $layout_registry;
  }
  
  public function setRegistries( $view_registry = null, $layout_registry = null)
  {
    $this->view_registry = $view_registry;
    $this->layout_registry = $layout_registry;
  }

  public function __get( $key )
  {
    return $this->data->$key;
  }
  
  
  public function __set( $key, $val )
  {
    $this->data->$key = $val;
  }
  
  
  public function __isset( $key )
  {
    return isset($this->data->$key);
  }
  
  
  public function __unset( $key )
  {
    unset($this->data->$key);
  }
      
  public function setData( $data )
  {
    $this->data = (object) $data;
  }
  
  public function addData( $data )
  {
    foreach ($data as $key => $val) 
    {
        $this->data->$key = $val;
    }
  }
  
  public function getData()
  {
    return $this->data;
  }
    
  protected function setContent( $content )
  {
    $this->content = $content;
  }
  
  protected function getContent()
  {
    return $this->content;
  }
  
  public function setLayout( $layout )
  {
    $this->layout = $layout;
  }
  
  public function getLayout()
  {
    return $this->layout;
  }

  protected function hasSection( $name )
  {
    return isset($this->section[$name]);
  }
  
  protected function setSection( $name, $body )
  {
    $this->section[$name] = $body;
  }
  
  protected function getSection( $name )
  {
    return $this->section[$name];
  }
  
  protected function beginSection( $name )
  {
    $this->capture[] = $name;
    ob_start();
  }
  
  protected function endSection()
  {
    $body = ob_get_clean();
    $name = array_pop($this->capture);
    $this->setSection($name, $body);
  }
     
  public function &getLayoutRegistry()
  {
    return $this->layout_registry;
  }
  
  public function setView( $view )
  {
    $this->view = $view;
  }
  
  public function getView()
  {
    return $this->view;
  }
  
  public function &getViewRegistry()
  {
    return $this->view_registry;
  }
  
  
  protected function setTemplateRegistry( $template_registry )
  {
    $this->template_registry = $template_registry;
  }
  
  protected function getTemplate( $name )
  {
    $tmpl = $this->template_registry->get($name);
    return $tmpl->bindTo($this, get_class($this));
  }
}