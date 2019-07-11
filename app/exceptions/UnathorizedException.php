<?php

namespace app\exceptions;

class UnathorizedException extends HttpException
{
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, 401, $code = 0, $previous);
    }
}
