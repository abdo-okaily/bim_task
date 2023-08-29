<?php

namespace App\Exceptions\Transactions\Addresses;

use Exception;

class AddressIsInternational extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 406;

	/**
	 * @var string
	 */
	protected $message = "Cannot COD Check out Address is international";
}
