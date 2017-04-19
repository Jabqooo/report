<?php

namespace Tlapnet\Report\Model\Result;

class EditableResult extends Result implements Mutable
{

	/**
	 * @param mixed $data
	 * @return void
	 */
	public function setData($data)
	{
		$this->data = $data;
	}

}
