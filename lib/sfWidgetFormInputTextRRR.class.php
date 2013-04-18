<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormInput represents an HTML text input tag.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormInputText.class.php 30762 2010-08-25 12:33:33Z fabien $
 */
class sfWidgetFormInputTextRRR extends sfWidgetForm
{
	/**
	 * Configures the current widget.
	 *
	 * @param array $options     An array of options
	 * @param array $attributes  An array of default HTML attributes
	 *
	 * @see sfWidgetForm
	 */
	protected function configure($options = array(), $attributes = array())
	{
		parent::configure($options, $attributes);

		$this->addRequiredOption('type');
		$this->setOption('type', 'text');
	}

	public function render($name, $value = null, $attributes = array(), $errors = array())
	{
		if(sfContext::getInstance()->getRequest()->isMethod('post'))
			$value = sfContext::getInstance()->getRequest()->getPostParameter($name);

		$render = $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value), $attributes));

		/*foreach((array)$errors as $error)
		{
			$render .= "<img src='/images/error.png'> <p class='error'>" . $error . "</p>";
		}

		if(sfContext::getInstance()->getRequest()->isMethod('post'))
			if(!count($errors))
				$render .= "<img src='/images/okay.png'>";
		*/

		return $render;
	}
}
