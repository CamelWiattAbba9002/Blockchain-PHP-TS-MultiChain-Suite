<?php
class BlockValidator {
    private $crypto;

    public function __construct() {
        $this->crypto = new CryptoEncrypt();
    }

    public function validateBlockHash(array $block): bool {
        $blockData = [
            'previous_hash' => $block['previous_hash'],
            'transactions' => $block['transactions'],
            'miner' => $block['miner'],
            'nonce' => $block['nonce'],
            'timestamp' => $block['timestamp']
        ];
        $calculatedHash = $this->crypto->sha256(json_encode($blockData));
        return $calculatedHash === $block['block_hash'];
    }

    public function validatePreviousHash(array $block, ?array $previousBlock): bool {
        if ($previousBlock === null) return true;
        return $block['previous_hash'] === $previousBlock['block_hash'];
    }

    public function validateTransactionSignatures(array $block): bool {
        foreach ($block['transactions'] as $tx) {
            if (!isset($tx['signature']) || empty($tx['signature'])) {
                return false;
            }
        }
        return true;
    }

    public function validateTimestamp(array $block, ?array $previousBlock): bool {
        if ($previousBlock === null) return true;
        return $block['timestamp'] > $previousBlock['timestamp'];
    }

    public function fullBlockValidate(array $block, ?array $previousBlock): bool {
        return $this->validateBlockHash($block) &&
               $this->validatePreviousHash($block, $previousBlock) &&
               $this->validateTransactionSignatures($block) &&
               $this->validateTimestamp($block, $previousBlock);
    }
}
?>
