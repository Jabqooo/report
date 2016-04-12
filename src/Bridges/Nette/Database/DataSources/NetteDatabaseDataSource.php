<?php

namespace Tlapnet\Report\Bridges\Nette\Database\DataSources;

use Nette\Database\Connection;
use Nette\Database\DriverException;
use Nette\Database\Helpers;
use Tlapnet\Report\DataSources\AbstractDatabaseDataSource;
use Tlapnet\Report\Exceptions\Runtime\DataSource\SqlException;
use Tlapnet\Report\Model\Data\Result;
use Tlapnet\Report\Model\Subreport\Parameters;
use Tracy\Debugger;

class NetteDatabaseDataSource extends AbstractDatabaseDataSource
{

	/** @var Connection */
	protected $connection;

	/**
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		parent::__construct($config);

		$this->connection = new Connection(
			sprintf(
				'%s:host=%s;dbname=%s',
				$this->getConfig('driver'),
				$this->getConfig('host'),
				$this->getConfig('database')
			),
			$this->getConfig('user'),
			$this->getConfig('password'),
			$this->getConfig('options', ['lazy' => TRUE])
		);
	}

	/**
	 * Show or hide tracy panel
	 *
	 * @param bool $show
	 */
	public function setTracyPanel($show)
	{
		if ($show === TRUE) {
			if (class_exists(Debugger::class)) {
				$this->connection->onConnect[] = function () {
					Helpers::createDebugPanel($this->connection);
				};
			}
		}
	}

	/**
	 * COMPILING ***************************************************************
	 */

	/**
	 * @param Parameters $parameters
	 * @return Result
	 * @throws SqlException
	 */
	public function compile(Parameters $parameters)
	{
		$expander = $parameters->createExpander();
		$sql = $this->getSql();

		// Replace placeholders
		$query = $expander->expand($sql);

		try {
			// Execute query
			$resulset = $this->connection->query($query);
		} catch (DriverException $e) {
			throw new SqlException($query, NULL, $e);
		}

		$report = new Result($resulset->fetchAll());

		return $report;
	}

}
