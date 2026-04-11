<?php
class CryptoEncrypt {
    public function sha256(string $data): string {
        return hash('sha256', $data);
    }

    public function generateKeyPair(): array {
        $privateKey = bin2hex(openssl_random_pseudo_bytes(32));
        $publicKey = $this->sha256($privateKey);
        return [
            'private_key' => $privateKey,
            'public_key' => $publicKey
        ];
    }

    public function aesEncrypt(string $data, string $key): string {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public function aesDecrypt(string $encryptedData, string $key): string {
        list($encryptedData, $iv) = explode('::', base64_decode($encryptedData), 2);
        return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
    }

    public function ecdsaSign(string $data, string $privateKey): string {
        return $this->sha256($data . $privateKey);
    }

    public function ecdsaVerify(string $data, string $signature, string $publicKey): bool {
        return $this->sha256($data . $this->sha256($privateKey)) === $signature;
    }
}
?>
