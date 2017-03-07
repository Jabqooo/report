<?php

namespace Tests\Cases\Model\Result;

use Tests\Engine\BaseTestCase;
use Tlapnet\Report\Model\Result\Helpers;
use Tlapnet\Report\Model\Result\Result;

final class HelpersTest extends BaseTestCase
{

	/**
	 * @covers Helpers::toArray
	 * @return void
	 */
	public function testToArray1()
	{
		$data = [1, 2, 3, 4];
		$r = new Result($data);
		$array = Helpers::toArray($r);

		$this->assertEquals($data, $array);
	}

	/**
	 * @covers Helpers::toArray
	 * @return void
	 */
	public function testToArray2()
	{
		$data = [['foo'], ['bar']];
		$r = new Result($data);
		$array = Helpers::toArray($r);

		$this->assertEquals($data, $array);
	}

}