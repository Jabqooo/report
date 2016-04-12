<?php

namespace Tlapnet\Report\Bridges\Neon\Loaders;

use Tlapnet\Report\Exceptions\Logic\InvalidArgumentException;
use Tlapnet\Report\Exceptions\Logic\NotImplementedException;
use Tlapnet\Report\Loaders\AbstractLoader;
use Tlapnet\Report\Model\Report\Report;

class NeonLoader extends AbstractLoader
{

	/** @var array */
	private $files = [];

	/** @var array */
	private $folders = [];

	/**
	 * @param string $file
	 */
	public function addFile($file)
	{
		if (!file_exists($file)) throw new InvalidArgumentException("Folder '$file' not found.");

		$this->files[] = $file;
	}

	/**
	 * @param string $folder
	 */
	public function addFolder($folder)
	{
		if (!is_dir($folder)) throw new InvalidArgumentException("Folder '$folder' not found.'");

		$this->folders[] = $folder;
	}

	/**
	 * @return Report[]
	 */
	public function load()
	{
		throw new NotImplementedException();
	}

}