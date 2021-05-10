<?php

namespace Mobtexting\Message;

use GuzzleHttp\Client as GuzzleHttpClient;

class Client
{
    protected $username;
    protected $password;
    protected $client;
    protected $endpoint = 'https://portal.mobtexting.com/api/v2/sms/send';
    protected $body;

    /**
     * Mobtexting constructor.
     *
     * @param string $username
     * @param string|null $password
     */
    public function __construct($username, $password = null, $client = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->client   = $client ?: new GuzzleHttpClient();
    }

    public function send($to, $params = [])
    {
        $to              = is_array($to) ? implode(',', $to) : $to;
        $params['to']    = $to;
        $params['token'] = $this->getToken();

        $params = $this->map($params);

        $response = $this->getClient()->post(
            $this->endpoint, [
                'form_params' => $params,
                'http_errors' => false,
            ],
        );

        $this->body = $response->getBody()->getContents();

        return $this;
    }

    public function json()
    {
        return $this->body;
    }

    protected function map($params = [])
    {
        $mapping = [
            'token' => 'access_token',
            'text'  => 'message',
            // 'to'    => 'to',
            'from'  => 'sender',
        ];

        foreach ($params as $key => $val) {
            if (isset($mapping[$key])) {
                $params[$mapping[$key]] = $val;
                unset($params[$key]);
            }
        }

        return $params;
    }

    public function getToken(): string
    {
        $token = $this->username;
        $token .= $this->password ? ':' . $this->password : '';

        return $token;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of client
     */
    public function getClient()
    {
        return $this->client;
    }
}
