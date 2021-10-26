<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class MontoException extends Exception
{
    public function __construct(string $message = "", int $code = 452)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['msg' => $this->message], $this->code);
        }

        return view('pages.error', ['msg' => $this->message]);
    }
}
