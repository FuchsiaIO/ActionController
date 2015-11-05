<?php

namespace ActionController\Filter;

interface iFilter
{
  public function filter( $action, $filters);
}