<?php namespace Dimti\SpaceWebTest;

use Curl\Curl;
use Dimti\SpaceWebTest\Contracts\JsonRpcRequest;
use Dimti\SpaceWebTest\Exceptions\SpaceWebTestException;
use Dimti\SpaceWebTest\Response\BaseJsonRpcResponse;
use Dimti\SpaceWebTest\Response\Contracts\JsonRpcResponse;
use Dimti\SpaceWebTest\Response\ErrorResponse;
use Dimti\SpaceWebTest\Response\NotAuthorized\GetTokenResponse;

abstract class BaseJsonRpcRequest implements JsonRpcRequest
{
    private string $token;

    /**
     * @throws SpaceWebTestException
     */
    protected function rpcRequest(string $method, array $params, JsonRpcResponse $castTo): JsonRpcResponse
    {
        $method = array_reverse(explode('::', $method))[0];

        $curl = new Curl();

        $curl->setHeader('Content-Type', 'application/json; charset=UTF-8');

        if (!($this instanceof NotAuthorized)) {
            $this->preparePersistentToken();

            $this->checkToken();

            $curl->setHeader('Authorization', 'Bearer ' . $this->getToken());
        }

        $jsonRpcRequestParams = [
            'jsonrpc' => '2.0',
            'id' => rand(0,10),
            'method' => $method,
            'params' => $params,
        ];

        $decodedResponse = $curl->post($this->getApiEndpointUrl(), json_encode($jsonRpcRequestParams));

        $rpcResponse = BaseJsonRpcResponse::castToJsonRpcResponse($decodedResponse, $castTo);

        if ($rpcResponse instanceof ErrorResponse) {
            throw new SpaceWebTestException(sprintf(
                'Some is wrong: %s (%d)',
                $rpcResponse->error->message,
                $rpcResponse->error->code
            ));
        }

        return $rpcResponse;
    }

    private function hasToken()
    {
        return isset($this->token);
    }

    private function getToken(): string
    {
        return $this->token;
    }

    private function preparePersistentToken(): void
    {
        if (!$this->hasToken() && file_exists($this->getPersistentSaveTokenFilePath())) {
            $this->setToken(file_get_contents($this->getPersistentSaveTokenFilePath()));
        }
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @throws SpaceWebTestException
     */
    private function checkToken(): void
    {
        if (!$this->hasToken()) {
            throw new SpaceWebTestException(sprintf(
                'You need set bearer token for use this RPC namespace %s',
                get_class($this)
            ));
        }
    }

    protected function isExistsPersistentTokenFile(): bool
    {
        return file_exists($this->getPersistentSaveTokenFilePath());
    }

    protected function getPersistentSaveTokenFileName(): string
    {
        return 'token';
    }

    protected function getPersistentSaveTokenFilePath(): string
    {
        return BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $this->getPersistentSaveTokenFileName();
    }
}
