<?php namespace Dimti\SpaceWebTest;

use Curl\Curl;
use Dimti\SpaceWebTest\Exceptions\SpaceWebTestException;
use Dimti\SpaceWebTest\Response\NotAuthorized\GetTokenResponse;

class NotAuthorized extends BaseJsonRpcRequest
{
    public function getApiEndpointUrl(): string
    {
        return 'https://api.sweb.ru/notAuthorized';
    }

    /**
     * @throws SpaceWebTestException
     */
    public function getToken(string $login, string $password, bool $persistentSaveToken = false): string
    {
        if ($persistentSaveToken && $this->isExistsPersistentTokenFile()) {
            return file_get_contents($this->getPersistentSaveTokenFilePath());
        }

        $getTokenResponse = $this->rpcRequest(__METHOD__, [
            'login' => $login,
            'password' => $password,
        ], new GetTokenResponse);

        assert($getTokenResponse instanceof GetTokenResponse);

        if ($persistentSaveToken) {
            file_put_contents($this->getPersistentSaveTokenFilePath(), $getTokenResponse->result);
        }

        return $getTokenResponse->result;
    }
}
