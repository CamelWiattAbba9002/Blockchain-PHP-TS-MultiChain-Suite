<?php
class WalletManager {
    private $wallets = [];
    private $crypto;

    public function __construct() {
        $this->crypto = new CryptoEncrypt();
    }

    public function createWallet(string $password): array {
        $keyPair = $this->crypto->generateKeyPair();
        $address = '0x' . substr($keyPair['public_key'], 0, 40);
        $encryptedPrivateKey = $this->crypto->aesEncrypt($keyPair['private_key'], $password);
        
        $this->wallets[$address] = [
            'address' => $address,
            'public_key' => $keyPair['public_key'],
            'encrypted_private_key' => $encryptedPrivateKey,
            'balance' => 0.0,
            'create_time' => time()
        ];
        return $this->wallets[$address];
    }

    public function getWalletBalance(string $address): float {
        return $this->wallets[$address]['balance'] ?? 0.0;
    }

    public function updateWalletBalance(string $address, float $amount): bool {
        if (isset($this->wallets[$address])) {
            $this->wallets[$address]['balance'] += $amount;
            return true;
        }
        return false;
    }

    public function validateAddress(string $address): bool {
        return str_starts_with($address, '0x') && strlen($address) === 42;
    }

    public function getWalletInfo(string $address): ?array {
        return $this->wallets[$address] ?? null;
    }
}
?>
