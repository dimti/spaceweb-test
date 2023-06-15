<?php namespace Dimti\SpaceWebTest\Response;

use Dimti\SpaceWebTest\Response\ErrorResponse\Error;
use stdClass;

class ErrorResponse extends BaseJsonRpcResponse
{
    public ?Error $error;

    /**
     * @param stdClass $decodedCurlResponse
     * @desc with error field
     */
    public function __construct(stdClass $decodedCurlResponse)
    {
        $this->error = new Error($decodedCurlResponse->error);

        parent::__construct($decodedCurlResponse);
    }
}
