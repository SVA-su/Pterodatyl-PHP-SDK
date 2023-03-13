<?php
namespace SVAsu\PterodactylPhpSDK\Locations;

use SVAsu\PterodactylPhpSDK\Pterodactyl;
use SVAsu\PterodactylPhpSDK\Http;

class Location {
    private Http $http;

    public function __construct(private Pterodactyl $data, private int $id = -1) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }

    public function listLocations(): array {
        return $this->http->request("/api/application/locations", "GET", []);
    }

    public function locationDetails(): array {
        return $this->http->request("/api/application/locations/{$this->id}", "GET", []);
    }

    public function createLocation(string $name, ?string $description): array {
        return $this->http->request("/api/application/locations", "POST", [
            "short" => $name,
            "long" => $description,
        ]);
    }

    public function updateLocation(string $name, ?string $description): array {
        return $this->http->request("/api/application/locations/{$this->id}", "PATCH", [
            "short" => $name,
            "long" => $description,
        ]);
    }

    public function deleteLocation(): array {
        return $this->http->request("/api/application/locations/{$this->id}", "DELETE", []);
    }
}