<?php

namespace Tlapnet\Report\Model\Data;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Tlapnet\Report\Exceptions\Logic\InvalidArgumentException;
use Traversable;

class Result implements Countable, ArrayAccess, Resultable
{

	/** @var array */
	protected $data = [];

	/**
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * COUNTABLE ***************************************************************
	 */

	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->data);
	}

	/**
	 * ARRAY ACCESS ************************************************************
	 */

	/**
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return isset($this->data[$offset]);
	}

	/**
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		if (!$this->offsetExists($offset)) {
			throw new InvalidArgumentException("Key '$offset' not found'");
		}

		return $this->data[$offset];
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->data[$offset] = $value;
	}

	/**
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		if (!$this->offsetExists($offset)) {
			throw new InvalidArgumentException("Key '$offset' not found'");
		}

		unset($this->data[$offset]);
	}

	/**
	 * ITERATOR ****************************************************************
	 */

	/**
	 * @return Traversable
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->data);
	}

}
