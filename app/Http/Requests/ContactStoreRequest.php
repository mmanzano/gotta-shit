<?php

namespace App\Http\Requests;

use GuzzleHttp\Client;
use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required',
            'body' => 'required',
            'email' => 'required|email',
        ];
    }

    public function validateRecaptcha(Client $client)
    {
        $response = $client->request(
            'POST',
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'query' => [
                    'secret' => config('services.recaptcha.server_secret'),
                    'response' => request('g-recaptcha-response'),
                ],
            ]
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        return $jsonResponse['success'] ?? false;
    }
}
