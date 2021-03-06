<?php
/**
 * Created by PhpStorm.
 * User: Diversant_
 * Date: 01.09.2017
 * Time: 17:53
 */

namespace SmartCAT\API\Manager;


use Joli\Jane\OpenApi\Runtime\Client\QueryParam;
use SmartCAT\API\Resource\UserResource;

class UserManager extends UserResource
{
    use SmartCATManager;

    /**
     *
     *
     * @param string $accountUserId
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Http\Promise\Promise|\Psr\Http\Message\ResponseInterface|\SmartCAT\API\Model\UserModel
     */
    public function userGet($accountUserId, $parameters = array(), $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/api/integration/v1/user/{accountUserId}';
        $url = str_replace('{accountUserId}', urlencode($accountUserId), $url);
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(array('Host' => $this->host, 'Accept' => array('application/json')), $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'SmartCAT\\API\\Model\\UserModel', 'json');
            }
        }
        return $response;
    }
}