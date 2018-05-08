<?php

namespace Mobtexting\Message;

use Mobtexting\Http\Client as HttpClient;

class Client
{
    protected $username;
    protected $password;
    protected $client;
    protected $endpoint = 'https://api.mobtexting.com/v1/sms';

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
        $this->client = $client ?: new HttpClient($this->endpoint);
    }

    public function send($to, $params = [])
    {
        $to = is_array($to) ? implode(',', $to) : $to;
        $params['to'] = $to;
        $params['token'] = $this->getToken();

        $params = $this->map($params);

        return $this->getClient()->post($params);
    }

    protected function map($params = [])
    {
        $mapping = [
            'token' => 'api_key',
            'text' => 'message',
            'to' => 'mobile_no',
            'from' => 'sender_id',
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
