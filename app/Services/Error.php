<?php

namespace App\Services;

use Facade\FlareClient\Stacktrace\Stacktrace;

class Error
{
    public string $message;
    public \Exception $e;
    public array $stackTrace;

    public function __construct(string $message, \Exception $e = null) {
        $this->stackTrace = debug_backtrace();
        $this->message = $message;
        if($e == null) {
            $this->e = new \Exception($message);
        }else{
            $this->e = $e;
        }

    }
}
