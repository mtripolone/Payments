<?php

namespace App\Services\Transference\Authorization;

use Exception;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeService
{
    public function transferAuthorizator()
    {
        $client = new Client();
        $response = $client->request('GET', config('services.authorizer.address'));
        $body = json_decode($response->getBody()->getContents());

        if ($response->getStatusCode() != Response::HTTP_OK && $body->message != 'Autorizado') {
            throw new Exception('Transação não Autorizada', Response::HTTP_UNAUTHORIZED);
        }
    }
}
