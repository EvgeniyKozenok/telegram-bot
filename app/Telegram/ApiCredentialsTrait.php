<?php


namespace App\Telegram;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait ApiCredentialsTrait
{

    public function getTestApiToken()
    {
        return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTQyNzYwNTBmMzkxYzhjM2ZlYWE2YmRhMzkxOTNiZjc1ZDIwMzY1ZWFmN2E5MzYyMzE5OGIxY2IxZmU1NDA2ZDY5OTczNDNkZmFjNDdiYjgiLCJpYXQiOjE2MDU3MzQ0MTAsIm5iZiI6MTYwNTczNDQxMCwiZXhwIjoxNjM3MjcwNDEwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.kyVvCypeP-nEra2CahCLBg3ml5xdgE20AIWMRMjy1gxYLi78y-kgiXUke21gx-kD5Pofg5rpe-ga2IcFYoSO7Ep9umNeyYQsyjx10VV9SK9l1h3sdNGYLoyhE-z8lgglAUpGmcUdCVUurANDuYfiqqo27HVQ7ceKucV25XnaB9ahVSa0s-0ZnDyCNcgj7z5pg_Y_tTlmk1iZrfmPIsitstOe-aAzAYMHnhb03WcAKLMbhWXhdgEytSGstPdMdJnnBLMLTgoTgtwhqEEY26rVjiSVyoywdsmnEZVuXAKXZl3nafCKFe74Y3kWBXQqeF4SJ6QSCSH766sWh3Sh5XTOmjtMnMPGTf5tsqDpGrlPE95KiIXUA30UtsWOxGf8DWE8PFt_VKIBt7s1A2Q5XzteUuhVXSACWQ3vJN00Ylg5ru9sqcb4E1U9ouA3nL7ZYfDR5lFmzk1Pn6ZNhttsxskGnB6UVXB4ctpAqIO7iKGYzpAILu4_YIaUg0bfcK8Tf1ldyMDMro3_SWXieSFYuR04bTsu9cL59ChKsLXbxcjQx7vvmMStZtoC0zTh_IL0881Y_UotPbbomkAmzJ-G3dfpuKhPgOYb_qr9H4ihjUggNleNlglM_WJo8zV6kCapcOYE1jt6Q_a3Tc9-AQnJkuHajcekPcnVTd2bj0DXPlkXw4M';
    }

    public function getTestApiUri($path)
    {
        return 'https://laravel-test.com/api/' . $path;
    }

    public function testApiGetRequest($path = '')
    {
        $client = new Client([
            'base_uri' => $this->getTestApiUri(''),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getTestApiToken(),
                'Accept'        => 'application/json',
            ],
            'verify' => false
        ]);

        try {
            $response = $client->request('GET', $path);
        } catch (GuzzleException $exception) {
            // todo handle exception
            exit;
        }
        return json_decode($response->getBody()->getContents(), true);
    }
}
