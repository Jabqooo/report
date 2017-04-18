<?php

namespace Tlapnet\Report\Bridges\Tracy\Export;

use Tlapnet\Report\Model\Export\AbstractExporter;
use Tlapnet\Report\Model\Result\Resultable;

class DebugExporter extends AbstractExporter
{

	/**
	 * @param Resultable $result
	 * @param array $options
	 * @return DebugExport
	 */
	public function export(Resultable $result, array $options = [])
	{
		return new DebugExport($result);
	}

}