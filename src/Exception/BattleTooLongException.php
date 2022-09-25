<?php

namespace App\Exception;

use App\Contract\Exception\BattleExceptionInterface;
use Throwable;

class BattleTooLongException extends \Exception implements BattleExceptionInterface
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
