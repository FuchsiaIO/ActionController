<?php

namespace ActionController\Registry\Test;

class TemplateRegistryTest extends \PHPUnit_Framework_TestCase
{
  
  protected function setUp()
  {
    $this->template_registry = new \ActionController\Registry\TemplateRegistry;
  }


  public function testSetHasGet()
  {
    $foo = function () {
      return "Foo!";
    };
  
    $this->assertFalse($this->template_registry->has('foo'));
  
    $this->template_registry->set('foo', $foo);
    $this->assertTrue($this->template_registry->has('foo'));
  
    $this->template = $this->template_registry->get('foo');
    $this->assertSame($foo, $this->template);
  
    $this->setExpectedException('\ActionController\Exception\TemplateNotFound');
    $this->template_registry->get('bar');
  }

  public function testSetString()
  {
    $this->template_registry->set('foo', dirname(__DIR__) . '/view/templates/foo_template.php');
    $template = $this->template_registry->get('foo');
    $this->assertInstanceOf('Closure', $template);
  
    ob_start();
      $template();
    $actual = ob_get_clean();
    $expect = 'Hello Foo!';
    $this->assertSame($expect, $actual);
  }

}
