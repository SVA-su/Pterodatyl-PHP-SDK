<?php
namespace SVAsu\PterodactylPhpSDK\Client;

use SVAsu\PterodactylPhpSDK\Pterodactyl;
use SVAsu\PterodactylPhpSDK\Http;

class User {
    
    private $http;

    public function __construct(private Pterodactyl $data, private int $id = -1) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }

    public function listServers(): array {
        return $this->http->request("/api/client", "GET", []);
    }

    public function getUserPerrmissions(): array {
        return $this->http->request("/api/client/permissions", "GET", []);
    }

    public function getAccountDetails(): array {
        return $this->http->request("/api/client/account/", "GET", []);
    }

    public function twoFactorDetails(): array {
        return $this->http->request("/api/client/account/two-factor", "GET", []);
    }

    public function enable2FA(string $OTP): array {
        return $this->http->request("/api/client/account/two-factor", "POST", ["code" => $OTP]);
    }

    public function disable2FA(string $password): array {
        return $this->http->request("/api/client/account/two-factor", "DELETE", ["password" => $password]);
    }

    public function updateEmail(string $email, string $password): array {
        return $this->http->request("/api/client/account/email", "PATCH", ["email" => $email, "password" => $password]);
    }

    public function updatePassword(string $password, string $newPassword, string $password_confirmation): array {
        return $this->http->request("/api/client/account/password", "PATCH", [
            "current_password" => $password, 
            "password" => $newPassword,
            "password_confirmation" => $password_confirmation
        ]);
    }
    
    public function listApiKeys() : array{
        return $this->http->request("/api/client/account/api-keys", "GET", []);
    }

    public function createApiKey(string $description, array $allowed_ips) : array {
        return $this->http->request("/api/client/account/api-keys", "POST", 
            ["description" => $description, "allowed_ips" => $allowed_ips]);
    }

    public function deleteApiKey(string $id) : array {
        return $this->http->request("/api/client/account/api-keys/{$id}", "DELETE", []);
    }

}