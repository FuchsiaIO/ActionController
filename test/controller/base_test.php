<?php

namespace ActionController\Test;

require_once 'mock_controller.php';

class BaseControllerTest extends \PHPUnit_Framework_TestCase
{
  protected $mock_controller;
  
  protected function setUp()
  {
    parent::setUp();
    $this->mock_controller = new \ActionController\Test\MockController;
    $this->mock_controller->render = new \ActionController\Response\Render;
    $this->mock_controller->greeting = "Hello World!";
  }
  
  protected function tearDown()
  {
    parent::tearDown();
  }
  
  public function testControllerInheritanceTree()
  {
    $this->assertInstanceOf('\ActionController\Controller\iAbstractController',$this->mock_controller,
      "Mock Controller does not have iAbstractController in its inheritance tree"
    );
    $this->assertInstanceOf('\ActionController\Controller\Base',$this->mock_controller,
      "Mock Controller does not have BaseController in its inheritance tree"
    );
  }
  
  public function testGetData()
  {
    $this->assertInternalType('array',$this->mock_controller->getData(),
      "Controller.getData does not return an instance of a Map"
    );
  }
  
  public function testSetClassVariables()
  {
    $this->assertEquals(count($this->mock_controller->getData()),1,
      "Failed to insert class attribute into controller.data"
    );
  }
  
  public function testGetClassVariables()
  {
    $this->assertEquals($this->mock_controller->greeting,"Hello World!",
      "Failed to get controller class variable"
    );
    $this->setExpectedException('\ActionController\Exception\UndefinedProperty');
    $this->mock_controller->fake_greeting;
  }
  
  public function testDefaultRendererFormat()
  {
    $this->assertEquals(count($this->mock_controller->getRenderer()->getData()),3,
      "Failed to set default render types to BaseController.renderer"
    );
  }
   
  public function testSetResponseDataTypes()
  {
    $this->mock_controller->respondTo( function($format) {
      $format->json = true;
    });
    
    $this->assertEquals(true,$this->mock_controller->getRenderer()->json,
      "Unable to set response data types"
    );
  }
  
  public function testGetSetView()
  {
    $this->mock_controller->setView('index.index');
    $this->assertSame($this->mock_controller->getView(), 'index.index');
  }
    
}