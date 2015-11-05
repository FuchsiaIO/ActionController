<?php

namespace ActionController\Controller;

interface iAbstractController
{
  public $view;
  protected $data;
  protected $render;
  
  public function __construct();
  public function respondTo(callable $lambda);
  public function getData();
  public function __set( $name, $value);
  public function __get( $name);
}