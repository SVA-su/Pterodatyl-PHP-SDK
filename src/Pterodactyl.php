<?php
namespace SVAsu\PterodactylPhpSDK;

class Pterodactyl {
    public function __construct(private string $PanelURI, private string $APIKey, private string $TypeKey){

    }
    
    public function getHost(): string{
        return $this->PanelURI;
    }
    public function getToken(): string{
        return $this->APIKey;
    }
}