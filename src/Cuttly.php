<?php

namespace Bramin\CuttlyPHP;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class Cuttly
{
    public function __construct(
        private string $baseUrl = 'https://cutt.ly'
    ) {
    }

    /**
     * @param array $query
     *
     * @return array
     * @throws CuttlyException|ConnectionException
     */
    private function sendRequest(array $query = []): array
    {
        $response = Http::get(
            $this->baseUrl . '/api/api.php',
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
            404 => new CuttlyException('404: URL not found'),
            default => new CuttlyException('500: Unknown exception from Cutt.ly'),
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
    public function createShortLink(string $short, string $name = '', bool $userDomain = null, bool $noTitle = null, bool $public = null): array
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
    public function deleteShortLink(string $short): bool
    {
        $parameters = [
            'edit' => $short,
            'delete' => 1,
        ];

        $response = $this->sendRequest($parameters);

        switch ($response['status']) {
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
