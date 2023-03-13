<?php
namespace SVAsu\PterodactylPhpSDK\Servers;

use SVAsu\PterodactylPhpSDK\Http;
use SVAsu\PterodactylPhpSDK\Pterodactyl;

class Server{
    
    private $http;
    
    public function __construct(private Pterodactyl $data, private int $id = -1){
        $this->http = new Http($data->getHost(), $data->getToken());
    }

    public function listServers(int $page = 1, int $perPage = 50): array {
        return $this->http->request("/api/application/servers", "GET", ["per_page" => $perPage, "page" => $page]);
    }

    public function serverDetails(): array {
        return $this->http->request("/api/application/servers/{$this->id}", "GET", []);
    }

    public function createServer(
        string $name, int $user_id, int $egg, string $image, string $start_up_command, array $environment,
        int $memory_limit, int $swap_limit, int $disk_limit, int $io_limit, int $cpu_limit,
        int $database_limit, int $backups_limit, int $default_allocation, array $ports, int $location,
        bool $delicated_ip = false, bool $start_on_completion = false
    ){
        return $this->http->request("/api/application/servers", "POST", [
            "name" => $name,
            "user" => $user_id,
            "egg" => $egg,
            "docker_image" => $image,
            "startup" => $start_up_command,
            "environment" => $environment,
            "limits" => ["memory" => $memory_limit, 
                        "swap" => $swap_limit, 
                        "disk" => $disk_limit, 
                        "io" => $io_limit, 
                        "cpu" => $cpu_limit],
            "feature_limits" => ["databases" => $database_limit, "backups" => $backups_limit],
            "allocation" => ["default" => $default_allocation],
            "deploy" => [
                'locations' => [$location],
                'dedicated_ip' => $delicated_ip,
                'port_range' => $ports 
            ],
            "start_on_completion" => $start_on_completion
        ]);
    }

    public function serverDetailsByExternalId(string $external_id): array {
        return $this->http->request("/api/application/servers/external/{$external_id}", "GET", []);
    }

    public function updateServer(
        string $name, int $user_id, int $egg, string $image, string $start_up_command, array $environment,
        int $memory_limit, int $swap_limit, int $disk_limit, int $io_limit, int $cpu_limit,
        int $database_limit, int $backups_limit, int $default_allocation, array $ports, int $location,
        bool $delicated_ip = false, bool $start_on_completion = false
    ){
        return $this->http->request("/api/application/servers/{$this->id}", "PATCH", [
            "name" => $name,
            "user" => $user_id,
            "egg" => $egg,
            "docker_image" => $image,
            "startup" => $start_up_command,
            "environment" => $environment,
            "limits" => ["memory" => $memory_limit, 
                        "swap" => $swap_limit, 
                        "disk" => $disk_limit, 
                        "io" => $io_limit, 
                        "cpu" => $cpu_limit],
            "feature_limits" => ["databases" => $database_limit, "backups" => $backups_limit],
            "allocation" => ["default" => $default_allocation],
            "deploy" => [
                'locations' => [$location],
                'dedicated_ip' => $delicated_ip,
                'port_range' => $ports 
            ],
            "start_on_completion" => $start_on_completion
        ]);
    }

    public function deleteServer(): array {
        return $this->http->request("/api/application/servers/{$this->id}", "DELETE", []);
    }

    public function reinstallServer(int $egg, string $image, string $start_up_command, array $environment): array {
        return $this->http->request("/api/application/servers/{$this->id}/reinstall", "POST", [
            "egg" => $egg,
            "docker_image" => $image,
            "startup" => $start_up_command,
            "environment" => $environment
        ]);
    }

    public function suspendServer(): array {
        return $this->http->request("/api/application/servers/{$this->id}/suspend", "POST", []);
    }

    public function unsuspendServer(): array {
        return $this->http->request("/api/application/servers/{$this->id}/unsuspend", "POST", []);
    }

    public function updateServerDetails(string $name, int $user, ?string $external_id, ?string $description): array {
        return $this->http->request("/api/application/servers/{$this->id}/details", "PATCH", [
            "name" => $name,
            "user" => $user,
            "external_id" => $external_id,
            "description" => $description
        ]);
    }

    public function updateServerBuild(int $allocation, int $memory, int $swap, int $io, int $cpu, int $disk, int $threads, int $database, int $backups, int $allocations): array {
        return $this->http->request("/api/application/servers/{$this->id}/build", "PATCH", [
            "allocation" => $allocation,
            "memory" => $memory,
            "swap" => $swap,
            "io" => $io,
            "cpu" => $cpu,
            "disk" => $disk,
            "threads" => $threads,
            "feature_limits" => [
                "databases" => $database,
                "backups" => $backups,
                "allocations" => $allocations
            ],
        ]);
    }

    public function updateServerStartup(string $command, string $egg, string $image, array $environment, ?bool $skip_scripts): array {
        return $this->http->request("/api/application/servers/{$this->id}/startup", "PATCH", [
            "command" => $command,
            "environment" => [
                $environment
            ],
            "egg" => $egg,
            "image" => $image,
            "skip_scripts" => $skip_scripts,
        ]);
    }
    
    public function deleteServerForce(): array {
        return $this->http->request("/api/application/servers/{$this->id}/force", "DELETE", []);
    }

    public function getDatabase(?string $host, ?string $password): array {
        return $this->http->request("/api/application/servers/{$this->id}/databases", "GET", [
            "include" => "{$host},{$password}"
        ]);
    }

    public function getDatabaseDetails(int $database_id): array {
        return $this->http->request("/api/application/servers/{$this->id}/databases/{$database_id}", "GET", []);
    }

    public function createDatabase(string $databaseName, string $remote, int $host): array {
        return $this->http->request("/api/application/servers/{$this->id}/databases", "POST", [
            "database" => $databaseName,
            "remote" => $remote,
            "host" => $host,
        ]);
    }

    public function deleteDatabase(int $database_id): array {
        return $this->http->request("/api/application/servers/{$this->id}/databases/{$database_id}", "DELETE", []);
    }

    public function resetPasswordDatabase(int $database_id): array {
        return $this->http->request("/api/application/servers/{$this->id}/databases/{$database_id}/reset-password", "POST", []);
    }
}
