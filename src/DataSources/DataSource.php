<?php

namespace Tlapnet\Report\DataSources;

use Tlapnet\Report\Model\Data\Resultable;
use Tlapnet\Report\Model\Subreport\Parameters;

interface DataSource
{

	/**
	 * @param Parameters $parameters
	 * @return Resultable
	 */
	public function compile(Parameters $parameters);

}
