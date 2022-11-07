<?php
require_once "api/Configuration.php";

class APIAuthHelper
{

    public function getHeader()
    {
        if (isset($_SERVER["REDIRECT_HTTP_AUTHORIZATION"])) {
            return $_SERVER["REDIRECT_HTTP_AUTHORIZATION"];
        }
        if (isset($_SERVER["HTTP_AUTHORIZATION"])) {
            return $_SERVER["HTTP_AUTHORIZATION"];
        }
        return null;
    }

    public function getBasicUserAndPass()
    {
        $header = $this->getHeader();
        if (strpos($header, "Basic ") === 0) {
            $userpass = explode(' ', $header)[1];
            $userpass = base64_decode($userpass);
            $userpass = explode(':', $userpass);
            if (count($userpass) == 2) {
                $user = new stdClass();
                $user->username = $userpass[0];
                $user->password = $userpass[1];
                return $user;
            }
        }
        return 400;
    }

    public function constructToken($username)
    {
        $header = array(
            "alg" => 'HS256',
            "typ" => 'JWT',
        );

        $payload = array(
            "exp" => time() + 60,
            "username" => $username,
            "role" => ROLE,
        );

        $header = json_encode($header);
        $payload = json_encode($payload);
        $header = $this->base64url_encode($header);
        $payload = $this->base64url_encode(($payload));
        $signature = hash_hmac("SHA256", "$header.$payload", SECRET, true);
        $signature = $this->base64url_encode($signature);
        $token = new stdClass();
        $token->token = "$header.$payload.$signature";
        return $token;
    }

    public function getPayload()
    {
        $header = $this->getHeader();
        if (strpos($header, "Bearer ") === 0) {
            $token = explode(" ", $header)[1];
            $parts = explode(".", $token);
            if (count($parts) === 3) {
                $header = $parts[0];
                $payload = $parts[1];
                $providedSignature = $parts[2];

                $realSignature = hash_hmac("SHA256", "$header.$payload", SECRET, true);
                $realSignature = $this->base64url_encode($realSignature);
 
                if ($providedSignature == $realSignature) {
                    return json_decode(base64_decode($payload));
                }
            } 
        }
        return null;
    }

    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
