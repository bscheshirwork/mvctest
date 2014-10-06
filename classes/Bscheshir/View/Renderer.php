<?php

namespace Bscheshir\View;


class Renderer
{
    /**
     * @var string Rendered content
     */
    private $__content = '';

    /**
     * Template being rendered
     *
     * @var null|string
     */
    private $__template = null;

    /**
     * Queue of templates to render
     * @var array
     */
    private $__templates = array();

    /**
     * Script file name to execute
     *
     * @var string
     */
    private $__file = null;

    /**
     * @var ArrayAccess|array ArrayAccess or associative array representing available variables
     */
    private $__vars;

    /**
     * Set variable storage
     *
     * Expects either an array, or an object implementing ArrayAccess.
     *
     * @param  array|ArrayAccess $variables
     * @return Renderer
     * @throws Exception\InvalidArgumentException
     */
    public function setVars($variables)
    {
        $this->__vars = $variables;
        return $this;
    }

    /**
     * Get a single variable, or all variables
     *
     * @param  mixed $key
     * @return mixed
     */
    public function vars($key = null)
    {
        if (null === $key) {
            return $this->__vars;
        }
        return $this->__vars[$key];
    }

    /**
     * Get a single variable
     *
     * @param  mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->__vars[$key];
    }
	
    public function __get($name)
    {
        $vars = $this->vars();
        return $vars[$name];
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param  string|Model $nameOrModel Either the template to use, or a
     *                                   ViewModel. The ViewModel must have the
     *                                   template as an option in order to be
     *                                   valid.
     * @param  null|array|Traversable $values Values to use when rendering. If none
     *                                provided, uses those in the composed
     *                                variables container.
     * @return string The script output.
     * @throws Exception\DomainException if a ViewModel is passed, but does not
     *                                   contain a template option.
     * @throws Exception\InvalidArgumentException if the values passed are not
     *                                            an array or ArrayAccess object
     * @throws Exception\RuntimeException if the template cannot be rendered
     */
    public function render($nameOrModel, $values = null)
    {

        // find the script file name using the parent private method
        $this->addTemplate($nameOrModel);
        unset($nameOrModel); // remove $name from local scope

        if (null !== $values) {
            $this->setVars($values);
        }
        unset($values);

        // extract all assigned vars (pre-escaped), but not 'this'.
        // assigns to a double-underscored variable, to prevent naming collisions
        $__vars = $this->vars();
        if (array_key_exists('this', $__vars)) {
            unset($__vars['this']);
        }
        extract($__vars);
        unset($__vars); // remove $__vars from local scope

        while ($this->__template = array_pop($this->__templates)) {
            $this->__file = $this->__template;
            if (!$this->__file) {
                throw new Exception\RuntimeException(sprintf(
                    '%s: Unable to render template "%s"; resolver could not resolve to a file',
                    __METHOD__,
                    $this->__template
                ));
            }
            try {
                ob_start();
                $includeReturn = include $this->__file;
                $this->__content = ob_get_clean();
            } catch (\Exception $ex) {
                ob_end_clean();
                throw $ex;
            }
            if ($includeReturn === false && empty($this->__content)) {
                throw new Exception\UnexpectedValueException(sprintf(
                    '%s: Unable to render template "%s"; file include failed',
                    __METHOD__,
                    $this->__file
                ));
            }
        }

        return $this->__content;
    }

    /**
     * Add a template to the stack
     *
     * @param  string $template
     * @return PhpRenderer
     */
    public function addTemplate($template)
    {
        $this->__templates[] = $template;
        return $this;
    }

}
