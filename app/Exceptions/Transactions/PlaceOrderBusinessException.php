<?php
namespace App\Exceptions\Transactions;

use App\Http\Resources\Api\CartResource;
use Exception;

class PlaceOrderBusinessException extends Exception {
    private CartResource $cartResource;
    private array $messages = [];

    public function __construct(string $msg) {
        parent::__construct($msg);
    }

    public function setCartResource(CartResource $cartResource) : self {
        $this->cartResource = $cartResource;
        return $this;
    }

    public function getCartResource() : CartResource | null {
        return isset($this->cartResource) ? $this->cartResource : null;
    }

    public function setMessages(array $messages) : self {
        $this->messages = $messages;
        return $this;
    }

    public function getMessages() : array {
        return $this->messages;
    }
}
