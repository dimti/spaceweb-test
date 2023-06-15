<?php namespace Dimti\SpaceWebTest;

use Dimti\SpaceWebTest\Exceptions\SpaceWebTestException;
use Dimti\SpaceWebTest\Response\Domains\MoveResponse;
use Dimti\SpaceWebTest\Response\NotAuthorized\GetTokenResponse;

class Domains extends BaseJsonRpcRequest
{
    public function getApiEndpointUrl(): string
    {
        return 'https://api.sweb.ru/domains';
    }

    /**
     * @param string $domain
     * @param string $prolongType
     * @desc 'none', 'bonus_money', 'manual'
     * @return int
     * @throws SpaceWebTestException
     * TODO: Ввести поддержку extendedResult
     */
    public function move(string $domain, string $prolongType = 'manual'): int
    {
        $rpcResponse = $this->rpcRequest(__METHOD__, [
            'domain' => $domain,
            'prolongType' => $prolongType,
        ], new GetTokenResponse);

        assert($rpcResponse instanceof MoveResponse);

        return $rpcResponse->result;
    }
}
