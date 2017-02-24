<?php

namespace Tlapnet\Report\Tests\DataSources;

use Tlapnet\Report\DataSources\ArrayDataSource;
use Tlapnet\Report\Model\Parameters\Parameters;
use Tlapnet\Report\Tests\BaseTestCase;

final class ArrayDataSourceTest extends BaseTestCase
{

	/**
	 * @covers ArrayDataSource::compile
	 * @covers ArrayDataSource::getData
	 * @return void
	 */
	public function testDefault()
	{
		$parameters = new Parameters();
		$data = [['foo' => 'bar']];
		$ds = new ArrayDataSource($data);

		$this->assertEquals($data, $ds->compile($parameters)->getData());
	}

}