<?php

namespace Tlapnet\Report\Bridges\Nette\UI\Response;

use Nette\Application\IResponse as UIResponse;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Tracy\Debugger;

class DebugResponse implements UIResponse
{

	/** @var mixed */
	private $payload;

	/**
	 * @param mixed $payload
	 */
	public function __construct($payload)
	{
		$this->payload = $payload;
	}

	/**
	 * @return mixed
	 */
	public function getPayload()
	{
		return $this->payload;
	}

	/**
	 * @param IRequest $httpRequest
	 * @param IResponse $httpResponse
	 * @return void
	 */
	public function send(IRequest $httpRequest, IResponse $httpResponse)
	{
		Debugger::dump($this->payload);
	}

}
