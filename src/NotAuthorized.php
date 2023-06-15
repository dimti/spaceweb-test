<?php namespace Dimti\SpaceWebTest;

use Curl\Curl;
use Dimti\SpaceWebTest\Exceptions\SpaceWebTestException;
use Dimti\SpaceWebTest\Response\ErrorResponse;
use Dimti\SpaceWebTest\Response\NotAuthorized\GetToken;

class NotAuthorized
{
    const API_ENDPOINT_URL = 'https://api.sweb.ru/notAuthorized';

    public function getToken(string $login, string $password, bool $persistentSaveToken = false): string
    {
        if ($persistentSaveToken && $this->isExistsPersistentTokenFile()) {
            return file_get_contents($this->getPersistentSaveTokenFilePath());
        }

        $curl = new Curl();

        $curl->setHeader('Content-Type', 'application/json; charset=UTF-8');

        $jsonRpcRequestParams = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'getToken',
            'params' => [
                'login' => $login,
                'password' => $password,
            ],
        ];

        $decodedResponse = $curl->post(self::API_ENDPOINT_URL, json_encode($jsonRpcRequestParams));

        $getTokenResponse = GetToken::castToJsonRpcResponse($decodedResponse);

        if ($getTokenResponse instanceof ErrorResponse) {
            throw new SpaceWebTestException(sprintf(
                'Some is wrong: %s (%d)',
                $getTokenResponse->error->message,
                $getTokenResponse->error->code
            ));
        }

        if ($persistentSaveToken) {
            file_put_contents($this->getPersistentSaveTokenFilePath(), $getTokenResponse->result);
        }

        return $getTokenResponse->result;
    }

    private function isExistsPersistentTokenFile(): bool
    {
        return file_exists($this->getPersistentSaveTokenFilePath());
    }

    private function getPersistentSaveTokenFileName(): string
    {
        return 'token';
    }

    private function getPersistentSaveTokenFilePath(): string
    {
        return BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $this->getPersistentSaveTokenFileName();
    }
}
