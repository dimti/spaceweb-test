<?php namespace Dimti\SpaceWebTest\Response;

use Dimti\SpaceWebTest\Response\Contracts\JsonRpcResponse;
use Dimti\SpaceWebTest\Response\Traits\Castable;
use stdClass;

abstract class BaseJsonRpcResponse implements JsonRpcResponse
{
    use Castable;

    public static function castToJsonRpcResponse(stdClass $decodedCurlResponse, JsonRpcResponse $castTo): JsonRpcResponse
    {
        $jsonRpcResponse = $castTo;

        if (isset($decodedCurlResponse->error) && $decodedCurlResponse->error) {
            $jsonRpcResponse = new ErrorResponse();
        }

        $jsonRpcResponse->castDecodedResponse($decodedCurlResponse);

        return $jsonRpcResponse;
    }

    public function castDecodedResponse(stdClass $decodedCurlResponse): void
    {
        $this->beforeCast($decodedCurlResponse);

        $this->cast($decodedCurlResponse);
    }

    public function beforeCast(stdClass $decodedCurlResponse): void
    {

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
