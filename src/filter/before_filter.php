<?php

namespace ActionController\Filter;

class BeforeFilter implements iFilter
{
  private $action;
  private $filter_actions = array();
  private $filter_method;
  
  public function filter( $action, array $filters )
  {
    $this->action = $action;
    
    foreach($filters as $filter_method => $included_actions)
    {
      $this->filter_method = $filter_method;
      
      $this->filter_action_list('except', $included_actions, false);
      $this->filter_action_list('only', $included_actions, true);
    }
    
    return $this->filter_actions;
  }
  
  private function filter_action_list( $filter_type, array $action_list, $add )
  {
    if(array_key_exists($filter_type, $action_list))
    {
      if( in_array($this->action, $action_list[$filter_type]) == $add )
      {
        $this->filter_actions[] = $this->filter_method;
      }
    }
  }
  
}