<?php namespace Dimti\SpaceWebTest\Response;

use Dimti\SpaceWebTest\Response\Contracts\JsonRpcResponse;
use Dimti\SpaceWebTest\Response\Traits\Castable;
use stdClass;

abstract class BaseJsonRpcResponse implements JsonRpcResponse
{
    use Castable;

    public function __construct(stdClass $decodedCurlResponse)
    {
        $this->cast($decodedCurlResponse);
    }

    public static function castToJsonRpcResponse(stdClass $decodedCurlResponse)
    {
        if (isset($decodedCurlResponse->error) && $decodedCurlResponse->error) {
            return new ErrorResponse($decodedCurlResponse);
        }

        $castTo = get_called_class();

        return new $castTo($decodedCurlResponse);
    }

    /**
     * @var string
     * @example "2.0"
     */
    public string $jsonrpc;

    /**
     * @var string
     * @example "1.184.20230613150428"
     */
    public string $version;

    /**
     * @var int
     * @example 1
     */
    public int $id;
}
