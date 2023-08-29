<?php

namespace App\Exceptions\Integrations\Shipping;

use Exception;

class AddressComponentNotFound extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 415;

	/**
	 * @var string
	 */
	protected $message = "Address Component Not Found";
}
