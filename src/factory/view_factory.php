<?php

namespace ActionController\Factory;

class ViewFactory
{
  public function newInstance()
  {
    return new \ActionController\View\Concrete(
      new \ActionController\Registry\TemplateRegistry,
      new \ActionController\Registry\TemplateRegistry
    );
  }
}