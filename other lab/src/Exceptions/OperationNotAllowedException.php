<?php

namespace src\Exceptions;

use Exception;

class OperationNotAllowedException extends Exception {

  public function __construct(string $message) 
  {
    $this->message = $message;
  }

  public function errorMessage() {
		$errorMsg = 'Operation is not allowed:'.$this->message;

    return $errorMsg;
  }
}