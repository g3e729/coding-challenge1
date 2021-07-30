<?php

namespace App\Services;

class RandomUserService
{
    protected $url = 'https://randomuser.me/api';

    public function getUsers($nationality = [], $results = 100)
    {
        $nationality = implode(',', $nationality);

        return $this->apiCall(compact('nationality', 'results'));
    }

    private function apiCall($params = [], $method = 'GET')
    {
        $results = [];
        try {
            $query = "";

            if (count($params)) {
                $query = "?".http_build_query($params);
            }

            $response = (new \GuzzleHttp\Client)->request($method, "{$this->url}$query");
            $response = json_decode($response->getBody()->getContents(), true);

            $results = $response['results'];
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        }

        return $results;
    }
}