<?php

namespace Src\Helpers;

class Curl
{
    public int $code;
    public string $message;
    public array $info;
    public mixed $data;

    public function __construct(string $path, array $options = [])
    {
        $this->connect($path, $options);
    }

    /**
     * Connect and communicate to API servers.
     *
     * @access protected
     * @param string $path api full path
     * @return void response data
     */
    private function connect(string $path, array $options): void
    {
        try {
            $ch = curl_init();
            foreach ($options as $option => $value) {
                curl_setopt($ch, $option, $value);
            }
            curl_setopt($ch, CURLOPT_URL, $path);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $response_info = curl_getinfo($ch);
            $response_code = (int)$response_info["http_code"];
            curl_close($ch);
            $this->code = $response_code;
            $this->info = $response_info;
            $this->data = $response;
            $this->message = "OK";
            if ($response_code === 0) $this->message = "Cannot connect with $path";
        } catch (\Exception $e) {
            $this->code = 500;
            $this->info = [];
            $this->data = null;
            $this->message = $e->getMessage();
        }
    }
}
