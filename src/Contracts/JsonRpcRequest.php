<?php namespace Dimti\SpaceWebTest\Contracts;

interface JsonRpcRequest
{
    public function getApiEndpointUrl(): string;
}
