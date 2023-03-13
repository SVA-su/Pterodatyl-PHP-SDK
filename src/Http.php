<?php
namespace SVAsu\PterodactylPhpSDK;

class Http {
    public function __construct(private string $URI, private string $APIKEY){}

    public function request(string $url, ?string $method = "GET", ?array $body = []): array {
        $url = "{$this->URI}{$url}";
        if(isset($body) and $method === "GET") $url .= '?'.http_build_query($body);
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer {$this->APIKEY}"
            ],
        ]);
        if(isset($body) and $method !== "GET") curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
          
        $response = json_decode(curl_exec($ch),true);
        
        $err = curl_error($ch);
        if($err) return ['body' => 'none', 'error' => $err, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)];

        return ['body' => $response, 'error' => 'none', 'code' => $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE)];
    }
}