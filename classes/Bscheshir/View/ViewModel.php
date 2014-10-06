<?php

namespace Bscheshir\View;


class ViewModel 
{
	use \Bscheshir\Traits\Variables;
    /**
	 * TODO
     * Template to use when rendering this model
     *
     * @var string
     */
    protected $template = '';

    /**
     * View variables in trait
     */

    /**
     * Constructor
     *
     * @param  null|array|Traversable $variables
     * @param  array|Traversable $options
     */
    public function __construct($variables = null, $options = null)
    {

        // Initializing the variables container
        $this->setVariables($variables, true);
		//TODO 
        if (null !== $options) {
            $this->setOptions($options);
        }
    }
	
	public function __invoke() {
		return $this->getVariables();
	}

}
