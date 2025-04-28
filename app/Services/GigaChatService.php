<?php

namespace App\Services;


use App\DTO\Admin\WordStoreDTO;
use App\Repositories\WordRepository;
use Illuminate\Support\Facades\Http;

class GigaChatService
{
    private string $token;

    public function __construct
    (
    )
    {
        $this->token = $this->getToken();
    }

    public function generate($word)
    {
        return $this->textRequest('Придумай предложение со словом ' . $word);
    }


    public function getToken()
    {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Basic MDE0ODRlZDktYTYzYy00NGVlLThjODMtMzRhMTYzNThmZDM5OmZmZTE0YWZlLTYzMTUtNGFmMi1hMGFlLThjOGUzM2MxOTY5MQ==',
                'RqUID' =>  $this->generateUUID(),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])
            ->withBody('scope=GIGACHAT_API_PERS', 'application/x-www-form-urlencoded')
            ->post('https://ngw.devices.sberbank.ru:9443/api/v2/oauth');

        $token = $response->json('access_token');

        return $token;
    }

    public function textRequest(string $text)
    {
        $request = Http::withoutVerifying()
            ->withHeader('Content-Type', 'application/json')
            //  ->withToken($this->getToken())
            ->withToken($this->token)
            ->post(
                'https://gigachat.devices.sberbank.ru/api/v1/chat/completions',
                [
                    'model' => 'GigaChat:latest',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $text,
                        ]
                    ],
                    'temperature' => 2,
                ]
            );

        return $request->json('choices.0.message.content');
    }

    public function generateUUID() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
