<?php
namespace SVAsu\PterodactylPhpSDK\Nests\Eggs;

use SVAsu\PterodactylPhpSDK\Pterodactyl;
use SVAsu\PterodactylPhpSDK\Http;

class Egg {
    private Http $http;

    public function __construct(private Pterodactyl $data, private int $idNest = -1, private int $id = -1) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }

    public function listEggs(): array {
        return $this->http->request("/api/application/nests/{$this->idNest}/eggs", "GET", []);
    }

    public function eggDetails(): array {
        return $this->http->request("/api/application/nests/{$this->idNest}/eggs/{$this->id}", "GET", []);
    }
}