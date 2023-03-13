<?php
namespace SVAsu\PterodactylPhpSDK\Client\Servers\Databases;

use SVAsu\PterodactylPhpSDK\Pterodactyl;
use SVAsu\PterodactylPhpSDK\Http;

class Database {
    private Http $http;
    private string $idDataBase;

    public function __construct(private Pterodactyl $data, private string $idServer) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }

    public function listDatabase(): array { 
        return $this->http->request("/api/client/servers/{$this->idServer}/databases", "GET", []);
    }

    public function createDatabase(string $name, string $allowed_ips): array { 
        return $this->http->request("/api/client/servers/{$this->idServer}/databases", "POST", [
            'database' => $name,
            'remote' => $allowed_ips,
        ]);
    }

    public function deleteDatabase(): array {
        return $this->http->request("/api/client/servers/{$this->idServer}/databases/{$this->idDataBase}", "DELETE", []);
    }

    public function rotatePassword(): array { 
        return $this->http->request("/api/client/servers/{$this->idServer}/databases/{$this->idDataBase}/rotate-password", "POST", []);
    }

    public function setDatabaseId(string $idDataBase): void {
        $this->idDataBase = $idDataBase;
    }

    public function getDatabaseId(): string {
        return $this->idDataBase;
    }

    public function emptyDatabaseId(): bool {
        return empty($this->idDataBase);
    }
}