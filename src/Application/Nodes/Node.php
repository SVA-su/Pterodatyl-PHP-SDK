<?php
namespace SVAsu\PterodactylPhpSDK\Nodes;

use SVAsu\PterodactylPhpSDK\Pterodactyl;
use SVAsu\PterodactylPhpSDK\Http;

class Node {
    private Http $http;
    public function __construct(Pterodactyl $data, private int $id = -1) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }
    
    public function listNodes(): array { 
        return $this->http->request("/api/application/nodes", "GET", []);
    }

    public function nodeDetails(): array {
        return $this->http->request("/api/application/nodes/{$this->id}", "GET", []);
    }

    public function nodeConfiguration(): array {
        return $this->http->request("/api/application/nodes/{$this->id}/configuration", "GET", []);
    }

    public function createNode(string $name, int $location_id, string $fqdn, 
        string $scheme, int $memory, int $memory_overallocate, int $disk,
        int $disk_overallocate, int $upload_size, int $daemon_sftp, int $daemon_listen): array {
        return $this->http->request("/api/application/nodes", "POST", [
                "name" => $name,
                "location_id" => $location_id,
                "fqdn" => $fqdn,
                "scheme" => $scheme,
                "memory" => $memory,
                "memory_overallocate" => $memory_overallocate,
                "disk" => $disk,
                "disk_overallocate" => $disk_overallocate,
                "upload_size" => $upload_size,
                "daemon_sftp" => $daemon_sftp, 
                "daemon_listen" => $daemon_listen,
        ]);
    }

    public function updateNode(string $name, string $description, int $location_id, string $fqdn, 
        string $scheme, int $memory, int $memory_overallocate, int $disk,
        int $disk_overallocate, int $upload_size, int $daemon_sftp, int $daemon_listen, 
        bool $behind_proxy = false, bool $maintenance_mode = false): array {
        return $this->http->request("/api/application/nodes/{$this->id}", "PATCH", [
                "name" => $name,
                "description" => $description,
                "location_id" => $location_id,
                "fqdn" => $fqdn,
                "scheme" => $scheme,
                "behind_proxy" => $behind_proxy,
                "maintenance_mode" => $maintenance_mode,
                "memory" => $memory,
                "memory_overallocate" => $memory_overallocate,
                "disk" => $disk,
                "disk_overallocate" => $disk_overallocate,
                "upload_size" => $upload_size,
                "daemon_sftp" => $daemon_sftp,
                "daemon_listen" => $daemon_listen,
            
        ]);
    }

    public function deleteNode(): array {
        return $this->http->request("/api/application/nodes/{$this->id}", "DELETE", []);
    }

    public function nodeAllocations(): array {
        return $this->http->request("/api/application/nodes/{$this->id}/allocations", "GET", []);
    }

    public function createNodeAllocation(string $ip, int $port, string $alias): array {
        return $this->http->request("/api/application/nodes/{$this->id}/allocations", "POST", [
            "ip" => $ip,
            "port" => $port,
            "alias" => $alias,
        ]);
    }

    public function deleteNodeAllocation(int $allocation_id): array {
        return $this->http->request("/api/application/nodes/{$this->id}/allocations/{$allocation_id}", "DELETE", []);
    }
    
}
