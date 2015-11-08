<?php
/**
 * View Factory
 */
namespace ActionController\Factory;

/**
* View Factory
*
* Constructs new Concrete Views
*
* @since        v0.0.1
* @version      v0.0.1
* @package      ActionController
* @subpackage   Factory
* @author       Benjamin J. Anderson <andeb2804@gmail.com>
*/
class ViewFactory
{
  
  /**
   * newInstance
   *
   * @since v0.0.1
   * @return ActionController\View\Concrete A concrete view
   */
  public function newInstance()
  {
    return new \ActionController\View\Concrete(
      new \ActionController\Registry\TemplateRegistry,
      new \ActionController\Registry\TemplateRegistry
    );
  }
  
}