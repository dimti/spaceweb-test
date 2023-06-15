<?php namespace Dimti\SpaceWebTest\Response\Domains;

use Dimti\SpaceWebTest\Response\BaseJsonRpcResponse;

class MoveResponse extends BaseJsonRpcResponse
{
    /**
     * @var int
     * @example 1
     */
    public int $result;
}
