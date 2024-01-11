<?php
namespace src\Http;

use src\Exceptions\HttpException;
use JsonException;

class Request
{
	private $get;
	private $server;
	private $body;

	public function __construct(
		array $get,
		array $server,
		string $body,
	)
	{
		$this->get = $get;
		$this->server = $server;
		$this->body = $body;
	}

	public function method(): string
  {
    if (!array_key_exists('REQUEST_METHOD', $this->server)) {
        throw new HttpException('Unable to get method');
    }
		
    return $this->server['REQUEST_METHOD'];
  }

	public function jsonBody(): array
	{
		try {
			$data = json_decode(
					$this->body,
					associative: true,
					flags: JSON_THROW_ON_ERROR
			);
		} catch (JsonException) {
				throw new HttpException('Cannot read json body');
		}

		if (!is_array($data)) {
				throw new HttpException('Invalid json body');
		}

		return $data;
	}

	public function jsonBodyField(string $field): mixed
  {
    $data = $this->jsonBody();

    if (!array_key_exists($field, $data)) {
        throw new HttpException("No such field: $field");
    }

    if (empty($data[$field])) {
        throw new HttpException("Empty field: $field");
    }
		
    return $data[$field];
  }

	public function path(): string
	{
		if (!array_key_exists('REQUEST_URI', $this->server)) {
			throw new HttpException('Unable to get path');
		}

		$components = parse_url($this->server['REQUEST_URI']);

		if (!is_array($components) || !array_key_exists('path', $components)) {
			throw new HttpException('Unable to get path');
		}

		return $components['path'];
	}

	public function query(string $param): string
	{
		if (!array_key_exists($param, $this->get)) {
			throw new HttpException("No such query param: $param");
		}

		$value = trim($this->get[$param]);

		if (empty($value)) {
			throw new HttpException("Empty query param: $param");
		}

		return $value;
	}

	public function header(string $header): string
	{
		$headerName = mb_strtoupper("http_" . str_replace('-', '_', $header));

		if (!array_key_exists($headerName, $this->server)) {
			throw new HttpException("Unable to get header: $header");
		}

		$value = trim($this->server[$headerName]);

		if (empty($value)) {
			throw new HttpException("Empty header: $header");
		}

		return $value;
	}
}