<?php

namespace Tlapnet\Report\Parameters;

use Tlapnet\Report\Exceptions\Logic\InvalidArgumentException;
use Tlapnet\Report\Parameters\Impl\Parameter;
use Tlapnet\Report\Subreport\Attachable;
use Tlapnet\Report\Utils\Expander;
use Tlapnet\Report\Utils\Suggestions;
use Tlapnet\Report\Utils\Switcher;

class Parameters implements Attachable
{

	// States
	const STATE_EMPTY = 1;
	const STATE_ATTACHED = 2;

	/** @var Parameter[] */
	private $parameters = [];

	/** @var int */
	private $state;

	/**
	 * Creates parameters
	 */
	public function __construct()
	{
		$this->state = self::STATE_EMPTY;
	}

	/**
	 * @param Parameter $parameter
	 * @return void
	 */
	public function add(Parameter $parameter)
	{
		$this->parameters[$parameter->getName()] = $parameter;
	}

	/**
	 * @param string $name
	 * @return Parameter
	 */
	public function get($name)
	{
		if (!isset($this->parameters[$name])) {
			$hint = Suggestions::getSuggestion(array_keys($this->parameters), $name);
			throw new InvalidArgumentException(Suggestions::format(sprintf('Unknown parameter "%s"', $name), $hint));
		}

		return $this->parameters[$name];
	}

	/**
	 * @return Parameter[]
	 */
	public function getAll()
	{
		return $this->parameters;
	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function attach(array $data)
	{
		$attached = [];
		foreach ($data as $key => $value) {
			// Fetch parameter
			$p = $this->get($key);

			// Set value to parameter
			$p->setValue($value);

			// Controle check - if we really have data
			if ($p->hasValue()) {
				$attached[] = $value;
			}
		}

		// Change state only if data was changed
		if ($attached) {
			$this->state = self::STATE_ATTACHED;
		}
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		$array = [];
		foreach ($this->parameters as $parameter) {
			// Fill only if parameter has a right value
			// or if parameter has default value
			// or if parameter can provide/compute value
			if ($parameter->hasValue()) {
				$array[$parameter->getName()] = $parameter->getValue();
			} else if ($parameter->hasDefaultValue()) {
				$array[$parameter->getName()] = $parameter->getDefaultValue();
			} else if ($parameter->canProvide()) {
				$array[$parameter->getName()] = $parameter->getProvidedValue();
			}
		}

		return $array;
	}

	/**
	 * @return bool
	 */
	public function isEmpty()
	{
		return count($this->parameters) <= 0;
	}


	/**
	 * @return bool
	 */
	public function isAttached()
	{
		return $this->state == self::STATE_ATTACHED;
	}

	/**
	 * @return bool
	 */
	public function canSwitch()
	{
		if ($this->isEmpty()) return FALSE;

		foreach ($this->parameters as $parameter) {
			if (!$parameter->canProvide()) return FALSE;
		}

		return TRUE;
	}

	/**
	 * HELPERS *****************************************************************
	 */

	/**
	 * @return Expander
	 */
	public function createExpander()
	{
		return new Expander($this->toArray());
	}

	/**
	 * @return Switcher
	 */
	public function createSwitcher()
	{
		return new Switcher($this->toArray());
	}

}