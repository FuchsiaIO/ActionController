<?php
/**
 * Response Validator
 */
namespace ActionController\Response;

/**
* Render Response Parser
*
* Registers a template, constructs a closure wrapping the file path
*
* @since        v0.0.1
* @version      v0.0.1
* @package      ActionController
* @subpackage   Response
* @author       Benjamin J. Anderson <andeb2804@gmail.com>
*/
class Render
{
  /** @var array $data Response formats */
  protected $data;
  
  /**
   * Constructs a new render response parser
   *
   * @since v0.0.1
   * @param array $formats an array containing valid responses
   */
  public function __construct($formats = array( 
    ".html" => false,
    ".xml"  => false,
    ".json" => false 
  ))
  {
    $this->data = $formats;
  }

  /**
   * Returns all recorded response types
   *
   * @since v0.0.1
   * @return array Recorded response types
   */  
  public function getData()
  {
    return $this->data;
  }
  
  public function __set( $name, $value )
  {
    $this->data['.'.$name] = $value;
  }
  
  public function __get( $name )
  {
    if( array_key_exists('.'.$name, $this->data) )
      return $this->data['.'.$name];
    else
      return false;
  }
}