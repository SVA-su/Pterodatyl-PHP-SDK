<?php
namespace SVAsu\PterodactylPhpSDK\Application\Users;
use SVAsu\PterodactylPhpSDK\Http;
use SVAsu\PterodactylPhpSDK\Pterodactyl;

class User {

    private Http $http;

    public function __construct(private Pterodactyl $data, private int $id = -1) {
        $this->http = new Http($data->getHost(), $data->getToken());
    }


    /**
     * Returns an array with users list
     * 
     * @package SVAsu\PterodactylPhpSDK\Application\Users
     * 
     * @param int $page    Page number
     * @param int $perPage Users per page
     * 
     * @return array
     */
    public function listUsers(int $page = 1, int $perPage = 50): array {
        return $this->http->request("/api/application/users", "GET", ["per_page" => $perPage, "page" => $page]);
    }
    
    /**
     * Returns an array with user details
     * 
     * @package SVAsu\PterodactylPhpSDK\Application\Users
     * @return array
     */

    public function userDetails(): array {
        return $this->http->request("/api/application/users/{$this->id}", "GET", []);
    }

    /**
     * Accepts user data, and returns an array
     * 
     * @package SVAsu\PterodactylPhpSDK\Application\Users
     * 
     * @param string $email      user email
     * @param string $username   user username
     * @param string $first_name user first name
     * @param string $last_name  user last name
     * @param string $password   user password
     * @param bool   $root_admin user root admin
     * 
     * @return array
     */
    public function createUser(string $email, string $username, string $first_name, string $last_name, string $password, bool $root_admin = false): array {
        return $this->http->request("/api/application/users", "POST", [
            "email" => $email,
            "username" => $username,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "password" => $password,
            "root_admin" => $root_admin
        ]);
    }

    /**
     * Accepts user data, and returns an array
     * 
     * @package SVAsu\PterodactylPhpSDK\Application\Users
     * @param string $external_id User external id
     * @return array
     */

    public function userDetailsByExternalId(string $external_id): array {
        return $this->http->request("/api/application/users/external/{$external_id}", "GET", []);
    }

    public function updateUser(string $email, string $username, string $first_name, string $last_name, string $password, string $lang): array {
        return $this->http->request("/api/application/users/{$this->id}", "PATCH", [
            "email" => $email,
            "username" => $username,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "language" => $lang,
            "password" => $password
        ]);
    }

    /**
     * Deletes a user
     * 
     * @package SVAsu\PterodactylPhpSDK\Application\Users
     * @return void
     */
    
    public function deleteUser(): void {
        $this->http->request("/api/application/users/{$this->id}", "DELETE", []);
    }
}
