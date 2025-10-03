<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke()
    {

        $token = $_POST['smart-token'];
        if (!$this->checkCaptcha($token)) { exit('you are bot!'); }


        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

       // Auth::login($user);

        return redirect('/home');
    }

    protected function checkCaptcha($token)
    {
        $captchaServerKey = env('CAPTCHA_SERVER_KEY');

        $ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
        $args = [
            "secret" => $captchaServerKey,
            "token" => $token,
            "ip" =>  $_SERVER['REMOTE_ADDR'], // Нужно передать IP-адрес пользователя.
            // Способ получения IP-адреса пользователя зависит от вашего прокси.
        ];
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode !== 200) {
            echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
            return true;
        }

        $resp = json_decode($server_output);
        return $resp->status === "ok";
    }


}
