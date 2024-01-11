<?php
namespace src\Http;

class SuccessfulResponse extends Response
{
	protected const SUCCEESS = true;

	private $data;

	public function __construct(
		array $data
	)
	{
		$this->data = $data;
	}

	protected function payload(): array
	{
		return ['data' => $this->data];
	}
}