<?php

namespace App\Services\Transference\Notification;

use Exception;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class NotificationService
{
    public function notifyClient()
    {
        $client = new Client();
        $response = $client->request('GET', config('services.notification.address'));
        $body = json_decode($response->getBody()->getContents());

        if ($response->getStatusCode() != Response::HTTP_OK && $body->message != 'Success') {
            throw new Exception('Não foi possivel envio de e-mail', Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
