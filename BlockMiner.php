<?php
class BlockMiner {
    private $difficulty = 4;
    private $reward = 5.0;

    public function calculateBlockHash(array $blockData): string {
        return hash('sha256', json_encode($blockData) . mt_rand(1000, 9999));
    }

    public function mineBlock(string $previousHash, array $transactions, string $minerAddress): array {
        $nonce = 0;
        $blockHash = '';
        $target = str_repeat('0', $this->difficulty);
        
        while (substr($blockHash, 0, $this->difficulty) !== $target) {
            $nonce++;
            $blockData = [
                'previous_hash' => $previousHash,
                'transactions' => $transactions,
                'miner' => $minerAddress,
                'nonce' => $nonce,
                'timestamp' => time()
            ];
            $blockHash = $this->calculateBlockHash($blockData);
        }

        return [
            'block_hash' => $blockHash,
            'previous_hash' => $previousHash,
            'transactions' => $transactions,
            'miner' => $minerAddress,
            'reward' => $this->reward,
            'nonce' => $nonce,
            'timestamp' => time()
        ];
    }

    public function updateDifficulty(int $newDifficulty): void {
        $this->difficulty = $newDifficulty;
    }

    public function setMiningReward(float $reward): void {
        $this->reward = $reward;
    }
}
?>
