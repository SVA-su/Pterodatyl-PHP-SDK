<?php
namespace SVAsu\PterodactylPhpSDK\Nests;

use SVAsu\PterodactylPhpSDK\Pterodactyl;
use SVAsu\PterodactylPhpSDK\Http;

class Nest {
    private Http $http;

    public function __construct(private Pterodactyl $data, private int $id = -1) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }

    public function listNests(): array {
        return $this->http->request("/api/application/nests", "GET", []);
    }

    public function nestDetails(): array {
        return $this->http->request("/api/application/nests/{$this->id}", "GET", []);
    }
}