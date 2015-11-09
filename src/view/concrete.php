<?php
/**
 * Concrete Implementation of the View Base
 */
namespace ActionController\View;

/**
* Concrete View Class
*
* Provides rendering functionality to view closures
*
* @since        v0.0.1
* @version      v0.0.1
* @package      ActionController
* @subpackage   View
* @author       Benjamin J. Anderson <andeb2804@gmail.com>
*/
class Concrete extends Base
{

  /**
   * Returns the rendered view along with any specified layout.
   *
   * @since v0.0.1
   * @return string
   */
  public function __invoke($vars = array())
  {
    $this->setTemplateRegistry($this->getViewRegistry());
    $this->setContent($this->render($this->getView(),$vars));

    $layout = $this->getLayout();
    if (! $layout) 
    {
      return $this->getContent();
    }
  
    $this->setTemplateRegistry($this->getLayoutRegistry());
    return $this->render($layout,$vars);
  }
  
  /**
   * Renders a template from the current template registry using output
   * buffering.
   *
   * @since v0.0.1
   * @param string $name The name of the template to be rendered.
   * @param array $vars Variables to `extract()` within the view as local
   * variables. Closure-based templates will need to call `extract()` on
   * their own.
   * @return string
   */
  protected function render($name, $vars = array())
  {
    $vars['this'] = $this;
    ob_start();
    $this->getTemplate($name)->__invoke($vars);
    return ob_get_clean();
  }
  
}