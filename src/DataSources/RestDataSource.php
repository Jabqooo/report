<?php

namespace Tlapnet\Report\DataSources;

use Tlapnet\Report\Exceptions\Logic\NotImplementedException;
use Tlapnet\Report\Model\Result\Result;
use Tlapnet\Report\Model\Parameters\Parameters;

class RestDataSource implements DataSource
{

	/**
	 * @param Parameters $parameters
	 * @return Result
	 */
	public function compile(Parameters $parameters)
	{
		throw new NotImplementedException();
	}

}
