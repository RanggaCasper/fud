<?php

namespace App\Services;

use Google_Client;
use Illuminate\Support\Str;
use Google\Service\SearchConsole;

class GSCService
{
    protected $client;
    protected $service;
    protected $siteUrl;

    public function __construct()
    {
        $this->siteUrl = 'sc-domain:' . Str::replace(['http://', 'https://'], '', env('APP_URL')); // contoh: sc-domain:fudz.my.id/

        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/private/google/account.json'));
        $this->client->addScope('https://www.googleapis.com/auth/webmasters.readonly');

        $this->service = new SearchConsole($this->client);
    }

    // Query per kata kunci
    public function getTopQueries($days = 7, $limit = 20)
    {
        return $this->fetchDimensionData(['query'], $days, $limit);
    }

    // Query per halaman
    public function getTopPages($days = 7, $limit = 20)
    {
        return $this->fetchDimensionData(['page'], $days, $limit);
    }

    // Negara
    public function getTopCountries($days = 7, $limit = 20)
    {
        return $this->fetchDimensionData(['country'], $days, $limit);
    }

    // Perangkat
    public function getTopDevices($days = 7, $limit = 10)
    {
        return $this->fetchDimensionData(['device'], $days, $limit);
    }

    // Search appearance (rich result)
    public function getSearchAppearances($days = 7, $limit = 10)
    {
        return $this->fetchDimensionData(['searchAppearance'], $days, $limit);
    }

    // Reusable fetcher
    protected function fetchDimensionData(array $dimensions, $days = 7, $limit = 20)
    {
        $end = now()->toDateString();
        $start = now()->subDays($days)->toDateString();

        $request = new \Google\Service\SearchConsole\SearchAnalyticsQueryRequest();
        $request->setStartDate($start);
        $request->setEndDate($end);
        $request->setDimensions($dimensions);
        $request->setRowLimit($limit);

        $response = $this->service->searchanalytics->query($this->siteUrl, $request);

        return collect($response->getRows() ?? []);
    }
}
