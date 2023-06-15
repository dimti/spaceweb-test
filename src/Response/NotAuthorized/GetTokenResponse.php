<?php namespace Dimti\SpaceWebTest\Response\NotAuthorized;

class GetTokenResponse extends \Dimti\SpaceWebTest\Response\BaseJsonRpcResponse
{
    /**
     * @var string
     * @example "dddd0oal6hh9tdaosacahudddd.d1c7abd8-dddd-dddd-dddd-14c3ba68aee9"
     */
    public string $result;
}
