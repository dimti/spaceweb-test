<?php namespace Dimti\SpaceWebTest\Response;

use Dimti\SpaceWebTest\Response\ErrorResponse\Error;
use stdClass;

class ErrorResponse extends BaseJsonRpcResponse
{
    public ?Error $error;

    public function beforeCast(stdClass $decodedCurlResponse): void
    {
        $this->error = new Error($decodedCurlResponse->error);
    }
}
