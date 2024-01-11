<?php

namespace src\Exceptions;

use Exception;

class EntityNotFoundException extends Exception {
  public function errorMessage() {
		$errorMsg = 'Entity was not found';

    return $errorMsg;
  }
}