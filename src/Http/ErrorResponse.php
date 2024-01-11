<?php
namespace src\Http;

class ErrorResponse extends Response
{
	protected const SUCCEESS = false;
	private $reason = "Something went wrong";

	public function __construct(
		string $reason
	)
	{
		$this->reason = $reason;
	}

	protected function payload(): array
	{
		return ['reason' => $this->reason];
	}
}