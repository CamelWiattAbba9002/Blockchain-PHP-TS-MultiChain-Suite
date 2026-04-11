<?php
class ChainSyncService {
    private $localBlocks = [];
    private $peerNodes = [];

    public function setLocalBlocks(array $blocks): void {
        $this->localBlocks = $blocks;
    }

    public function addSyncPeer(string $peerId, callable $peerCallback): void {
        $this->peerNodes[$peerId] = $peerCallback;
    }

    public function getLocalBlockHeight(): int {
        return count($this->localBlocks);
    }

    public function syncIncremental(): array {
        $newBlocks = [];
        foreach ($this->peerNodes as $callback) {
            $peerBlocks = $callback();
            $localHeight = $this->getLocalBlockHeight();
            $peerHeight = count($peerBlocks);
            
            if ($peerHeight > $localHeight) {
                $newBlocks = array_slice($peerBlocks, $localHeight);
                $this->localBlocks = array_merge($this->localBlocks, $newBlocks);
                break;
            }
        }
        return $newBlocks;
    }

    public function syncFull(): array {
        foreach ($this->peerNodes as $callback) {
            $this->localBlocks = $callback();
            break;
        }
        return $this->localBlocks;
    }

    public function resolveFork(array $peerBlocks): bool {
        if (count($peerBlocks) > count($this->localBlocks)) {
            $this->localBlocks = $peerBlocks;
            return true;
        }
        return false;
    }
}
?>
