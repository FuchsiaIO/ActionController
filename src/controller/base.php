<?php

/**
 * Base Controller-View Class
 */
namespace ActionController\Controller;

/**
* Base Controller Class
*
* Provides an interface for Responses, Action Filters, and View Rendering.
*
* @since        v0.0.1
* @version      v0.0.1
* @package      ActionController
* @subpackage   Controller
* @author       Benjamin J. Anderson <andeb2804@gmail.com>
*/
abstract class Base implements iAbstractController
{
  /** @var string $view The view associated with a controllers action to be rendered. */
  private $view = null;

  /** @var string $template The template associated with a controllers action to be rendered. */
  private $template = null;
    
  /** @var ActionController\Response\Render $render A controllers response parser and validator. */
  public $render;
  
  /** @var array $before_filter Action filters to be executed before a request is served through the controller */
  public static $before_filter = array();
  
  /** @var array $data Class variables to be passed to the associated view. */
  protected $data = array();
  
  /**
   * Default Constructor
   *
   * @since v0.0.1
   * 
   */
  public function __construct(){}
  
  /**
   * Assigns valid response types to the renderer
   *
   * @since v0.0.1
   * @param callable $lambda Callback function.
   */
  public function respondTo(callable $lambda)
  {
    call_user_func($lambda, $this->getRenderer());
  }
  
  /**
   * Check to see if a controller action can respond to a specific format
   *
   * @since v0.0.1
   * @return bool True if a valid response type, false if not.
   */
  public function canRespondTo($type = '.html')
  {
    $type = str_replace('.', '', $type);
    return $this->render->$type ? true : false;
  }
  
  /**
   * Returns the data that will be passed to the view
   *
   * @since v0.0.1
   * @return array View data
   */
  public function getData()
  {
    return $this->data;
  }
  
  /**
   * Returns and instantiates a new response renderer
   *
   * @since v0.0.1
   * @return ActionController\Response\Render A pointer to the controller renderer
   */
  public function &getRenderer()
  {
    if(is_null($this->render))
    {
      $this->render = new \ActionController\Response\Render;
    }
    return $this->render;
  }
  
  /**
   * Sets the view for the controller to instantiate
   *
   * @param string $alias The view alias.
   * @since v0.0.3
   */  
  public function setView( $alias )
  {
    $this->view = $alias;
  }
  
  /**
   * Returns the view alias to be instantiated
   *
   * @since v0.0.1
   * @return string The view alias
   */
  public function getView()
  {
    return $this->view;
  }
  
  /**
   * Sets the template for the controller to instantiate
   *
   * @param string $alias The template alias.
   * @since v0.0.3
   */  
  public function setTemplate( $alias )
  {
    $this->template = $alias;
  }
  
  /**
   * Returns the template alias to be instantiated
   *
   * @since v0.0.1
   * @return string The template alias
   */
  public function getTemplate()
  {
    return $this->template;
  }
  
  /**
   * Applies a filter to a specified action if applicable
   *
   * @since v0.0.1
   * @param string $action    The Action to filter
   * @param string $type      The type of filter to apply
   * @param string $namespace Namespace in which the filters reside
   */
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
  
  /**
   * Returns the filter properties
   *
   * @since v0.0.1
   * @param string $filter_type The type of filter to return
   * @return array A filter list
   */
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
  
  /**
   * Redirects a request within a controller
   *
   * @since v0.0.1
   * @param string $url           The url to redirect to.
   * @param bool   $replace       Replace the current URL
   * @param int    $redurect_code The redirect code
   * @param string $content_type  The response content format
   */
  protected function redirect_to( $url, $replace = true, $redirect_code = 301, $content_type = 'text/html')
  {
    header('Content-Type: '.$content_type);
    header('Location: '.$url, $replace, $redirect_code);
  }
  
  /**
   * Executes an array of actions from a filter
   *
   * @since v0.0.1
   * @param array $actions A list of actions to execute
   */
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