<?php
  
namespace ActionController\Filter;  

class FilterFactory
{
  public static function newInstance( $type, $namespace)
  {
    $class = $namespace.$type.'Filter';
    return new $class();
  }
}