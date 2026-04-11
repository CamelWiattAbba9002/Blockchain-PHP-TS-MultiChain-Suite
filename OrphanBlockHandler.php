<?php
class OrphanBlockHandler {
    private $orphanBlocks = [];
    private $mainChain = [];

    public function setMainChain(array $chain): void {
        $this->mainChain = $chain;
    }

    public function addOrphanBlock(array $block): void {
        $this->orphanBlocks[$block['block_hash']] = $block;
    }

    public function findOrphanByPreviousHash(string $hash): ?array {
        foreach ($this->orphanBlocks as $block) {
            if ($block['previous_hash'] === $hash) {
                return $block;
            }
        }
        return null;
    }

    public function resolveOrphans(): array {
        $resolvedBlocks = [];
        foreach ($this->orphanBlocks as $hash => $block) {
            $lastBlock = end($this->mainChain);
            if ($lastBlock && $lastBlock['block_hash'] === $block['previous_hash']) {
                $this->mainChain[] = $block;
                $resolvedBlocks[] = $block;
                unset($this->orphanBlocks[$hash]);
            }
        }
        return $resolvedBlocks;
    }

    public function getOrphanBlocks(): array {
        return $this->orphanBlocks;
    }

    public function rebuildChain(array $newChain): bool {
        if (count($newChain) > count($this->mainChain)) {
            $this->mainChain = $newChain;
            $this->orphanBlocks = [];
            return true;
        }
        return false;
    }
}
?>
