<?php
namespace SVAsu\PterodactylPhpSDK\Client\Servers;

use SVAsu\PterodactylPhpSDK\Client\Servers\Databases\Database;
use SVAsu\PterodactylPhpSDK\Client\Servers\Backups\Backup;
use SVAsu\PterodactylPhpSDK\Pterodactyl;
use SVAsu\PterodactylPhpSDK\Http;

class Server {
    private Http $http;

    public const POWER_START = 'start';
    public const POWER_STOP = 'stop';
    public const POWER_RESTART = 'restart';
    public const POWER_KILL = 'kill';

    public function __construct(private Pterodactyl $data, private string $id) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }

    public function getDetails() : array {
        return $this->http->request("/api/client/servers/{$this->id}", "GET", []);
    }

    public function getResourceUsage() : array {
        return $this->http->request("/api/client/servers/{$this->id}/resources", "GET", []);
    }

    public function getConsoleWebSocket() : array {
        return $this->http->request("/api/client/servers/{$this->id}/websocket", "GET", []);
    }
    public function start(): bool {
        return $this->setPower(self::POWER_START)['code'] === 204;
    }

    public function stop(): bool {
        return $this->setPower(self::POWER_STOP)['code'] === 204;
    }

    public function restart() : bool {
        return $this->setPower(self::POWER_RESTART)['code'] === 204;
    }

    public function kill(): bool {
        return $this->setPower(self::POWER_KILL)['code'] === 204;
    }

    protected function setPower(string $signal): array {
        $signal = strtolower($signal);
        if ($signal === self::POWER_START 
            or $signal === self::POWER_STOP 
            or $signal === self::POWER_RESTART 
            or $signal === self::POWER_KILL)
            return $this->http->request("/api/client/servers/{$this->id}/power", "POST", ['signal' => $signal]);
        return [];
    }

    public function sendCommand(string $command) : array {
        return $this->http->request("/api/client/servers/{$this->id}/command", "POST", ['command' => $command]);
    }

    public function getDatabase(string $databaseID): Databases\Database {
        $database = new Databases\Database($this->data, $this->id);
        $database->setDatabaseId($databaseID);
        return $database;
    }

    public function getBackup(string $backupId): Backups\Backup {
        $backup = new Backups\Backup($this->data, $this->id);
        $backup->setBackupId($backupId);
        return $backup;
    }

    public function renameServer(string $servername): array {
        return $this->http->request("/api/client/servers/{$this->id}/settings/rename", "POST", ['name' => $servername]);
    }

    public function reinstallServer(): array {
        return $this->http->request("/api/client/servers/{$this->id}/settings/reinstall", "POST", []);
    }

    public function getVariables(): array {
        return $this->http->request("/api/client/servers/{$this->id}/startup", "GET", []);
    }

    public function updateVariable(string $key, string $value): array {
        return $this->http->request("/api/client/servers/{$this->id}/startup/variable", "PUT", 
            ['key' => $key, 'value' => $value]);
    }
}