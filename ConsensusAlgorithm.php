<?php
class ConsensusAlgorithm {
    private $consensusType = 'pow_pos';
    private $validatorNodes = [];

    public function setConsensusType(string $type): void {
        $this->consensusType = $type;
    }

    public function addValidatorNode(string $nodeId, int $stake): void {
        $this->validatorNodes[$nodeId] = [
            'stake' => $stake,
            'status' => 'active',
            'vote_count' => 0
        ];
    }

    public function verifyBlock(array $block): bool {
        if ($this->consensusType === 'pow') {
            $target = str_repeat('0', 4);
            return substr($block['block_hash'], 0, 4) === $target;
        }
        
        if ($this->consensusType === 'pow_pos') {
            $validStake = array_sum(array_column($this->validatorNodes, 'stake')) > 0;
            $hashValid = substr($block['block_hash'], 0, 3) === '000';
            return $validStake && $hashValid;
        }
        return false;
    }

    public function voteBlock(string $nodeId, string $blockHash): bool {
        if (isset($this->validatorNodes[$nodeId])) {
            $this->validatorNodes[$nodeId]['vote_count']++;
            return true;
        }
        return false;
    }

    public function getConsensusStatus(): array {
        return [
            'type' => $this->consensusType,
            'validator_count' => count($this->validatorNodes),
            'total_stake' => array_sum(array_column($this->validatorNodes, 'stake'))
        ];
    }
}
?>
