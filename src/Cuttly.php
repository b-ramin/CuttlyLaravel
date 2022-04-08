<?php

namespace Bramin\CuttlyPHP;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class Cuttly
{
    /**
     * @param array $query
     *
     * @return array
     * @throws CuttlyException|ConnectionException
     */
    private function sendRequest(array $query = []): array
    {
        $response = Http::get(
            config('cuttly.url'),
            array_merge(['key' => config('cuttly.key')], $query)
        );

        if ($response->ok()) {
            if ($response->json() == 'Subscription has expired') {
                throw new CuttlyException('Your subscription does not support this functionality or you\'ve reached your shortening limit');
            }

            return $response->json();
        }

        throw match ($response->status()) {
            401 => new CuttlyException('401: Invalid API key'),
            404 => new ConnectionException('404: URL not found'), // Throw a ConnectionException instead of CuttlyException to match 404 from Http::get.
            default => new CuttlyException('Unknown exception from Cutt.ly'),
        };
    }

    /**
     * @return bool
     * @throws CuttlyException|ConnectionException
     */
    public function ping(): bool
    {
        $response = $this->sendRequest();

        return $response['auth'];
    }

    /**
     * @param string $short
     * @param string $name
     * @param bool $userDomain
     * @param bool $noTitle
     * @param bool $public
     *
     * @return array
     * @throws CuttlyException|ConnectionException
     */
    public function create(string $short, string $name = '', bool $userDomain = null, bool $noTitle = null, bool $public = null): array
    {
        $parameters = array_merge(
            ['short' => $short],
            $name ? ['name' => $name] : [],
            ['userDomain' => isset($userDomain) ? (int)$userDomain : config('cuttly.user_domain')],
            ['noTitle' => isset($noTitle) ? (int)$noTitle : config('cuttly.no_title')],
            ['public' => isset($public) ? (int)$public : config('cuttly.public')],
        );

        $response = $this->sendRequest($parameters);

        switch ($response['url']['status']) {
            case 1:
                throw new CuttlyException('the shortened link comes from the domain that shortens the link, i.e. the link has already been shortened');
            case 2:
                throw new CuttlyException('the entered link is not a link');
            case 3:
                throw new CuttlyException('the preferred link name is already taken');
            case 4:
                throw new CuttlyException('Invalid API key');
            case 5:
                throw new CuttlyException('the link has not passed the validation. Includes invalid characters');
            case 6:
                throw new CuttlyException('The link provided is from a blocked domain');
            case 7:
                return $response['url'];
            default:
                throw new CuttlyException('Unknown response from Cuttly');
        }
    }

    /**
     * @param string $short
     *
     * @return bool
     * @throws ConnectionException
     * @throws CuttlyException
     */
    public function delete(string $short): bool
    {
        $parameters = [
            'edit' => $short,
            'delete' => 1,
        ];

        $response = $this->sendRequest($parameters);

        return self::parseEditResponse($response['status']);
    }

    /**
     * @param string $short
     * @param string $tag
     *
     * @return bool
     * @throws ConnectionException
     * @throws CuttlyException
     */
    public function addTag(string $short, string $tag): bool
    {
        $parameters = [
            'edit' => $short,
            'tag' => $tag,
        ];

        $response = $this->sendRequest($parameters);

        return self::parseEditResponse($response['status']);
    }

    /**
     * @param string $short
     * @param string $source
     *
     * @return bool
     * @throws ConnectionException
     * @throws CuttlyException
     */
    public function updateSource(string $short, string $source): bool
    {
        $parameters = [
            'edit' => $short,
            'source' => $source,
        ];

        $response = $this->sendRequest($parameters);

        return self::parseEditResponse($response['status']);
    }

    /**
     * @param string $short
     * @param string $title
     *
     * @return bool
     * @throws ConnectionException
     * @throws CuttlyException
     */
    public function updateTitle(string $short, string $title): bool
    {
        $parameters = [
            'edit' => $short,
            'title' => $title,
        ];

        $response = $this->sendRequest($parameters);

        return self::parseEditResponse($response['status']);
    }

    /**
     * @param string $short
     * @param string|null $dateFrom
     * @param string|null $dateTo
     *
     * @return array
     * @throws ConnectionException
     * @throws CuttlyException
     */
    public function getAnalytics(string $short, string $dateFrom = null, string $dateTo = null): array
    {
        if (isset($dateFrom) && ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dateFrom)) {
            throw new CuttlyException('dateFrom must match YYYY-MM-DD format');
        }

        if (isset($dateTo) && ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dateTo)) {
            throw new CuttlyException('dateTo must match YYYY-MM-DD format');
        }

        $parameters = array_merge(
            ['stats' => $short],
            $dateFrom ? ['date_from' => $dateFrom] : [],
            $dateTo ? ['date_to' => $dateTo] : [],
        );

        $response = $this->sendRequest($parameters);

        if ($response['stats']['status'] !== 1) {
            // Cutt.ly docs do not provide any guidance for error handling on this call beyond "status of 1 is success".
            throw new CuttlyException('Something went wrong.');
        }

        return $response['stats'];
    }

    /**
     * @param int $status
     *
     * @return bool
     * @throws CuttlyException
     */
    private static function parseEditResponse(int $status): bool
    {
        switch ($status) {
            case 1:
                return true;
            case 2:
                throw new CuttlyException('Could not save in database');
            case 3:
                throw new CuttlyException('The url does not exist or you do not own it');
            case 4:
                throw new CuttlyException('URL didn\'t pass the validation');
            default:
                throw new CuttlyException('Unknown response from Cuttly');
        }
    }
}
