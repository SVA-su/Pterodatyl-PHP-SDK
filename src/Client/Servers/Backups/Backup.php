<?php
namespace SVAsu\PterodactylPhpSDK\Client\Servers\Backups;

use SVAsu\PterodactylPhpSDK\Pterodactyl;
use SVAsu\PterodactylPhpSDK\Http;

class Backup {
    private Http $http;
    private string $backupId;

    public function __construct(private Pterodactyl $data, private string $id) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }

    public function listBackups(): array {
        return $this->http->request("/api/client/servers/{$this->id}/backups", "GET", []);
    }

    public function createBackup(): array {
        return $this->http->request("/api/client/servers/{$this->id}/backups", "POST", []);
    }

    public function deleteBackup(): array {
        return $this->http->request("/api/client/servers/{$this->id}/backups/{$this->backupId}", "DELETE", []);
    }

    public function downloadBackup(): array {
        return $this->http->request("/api/client/servers/{$this->id}/backups/{$this->backupId}/download", "GET", []);
    }

    public function getBackupInfo(): array {
        return $this->http->request("/api/client/servers/{$this->id}/backups/{$this->backupId}", "GET", []);
    }

    public function setBackupId(string $idDataBase): void {
        $this->backupId = $idDataBase;
    }

    public function getBackupId(): string {
        return $this->backupId;
    }

    public function emptyBackupId(): bool {
        return empty($this->backupId);
    }    
}