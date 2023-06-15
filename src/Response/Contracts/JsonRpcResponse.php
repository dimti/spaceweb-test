<?php namespace Dimti\SpaceWebTest\Response\Contracts;

use stdClass;

interface JsonRpcResponse
{
    public function castDecodedResponse(stdClass $decodedCurlResponse): void;
    public function beforeCast(stdClass $decodedCurlResponse): void;
}
