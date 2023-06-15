<?php namespace Dimti\SpaceWebTest\Response\ErrorResponse;

use Dimti\SpaceWebTest\Response\Traits\Castable;
use stdClass;

class Error
{
    use Castable;

    public function __construct(stdClass $errorData)
    {
        $this->cast($errorData);
    }

    /**
     * @var int
     * @example -32400
     */
    public int $code;

    /**
     * @var string
     * @example "Wrong password"
     */
    public string $message;

    /**
     * @var array
     * @example []
     */
    public array $data;
}
