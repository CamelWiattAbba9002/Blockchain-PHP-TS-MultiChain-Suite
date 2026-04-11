<?php
class BlockchainNode {
    private $nodeId;
    private $nodeHost;
    private $nodePort;
    private $peerNodes = [];
    private $nodeStatus = 'online';

    public function __construct(string $host, int $port) {
        $this->nodeHost = $host;
        $this->nodePort = $port;
        $this->nodeId = hash('sha256', uniqid(mt_rand(), true));
    }

    public function addPeerNode(string $peerId, string $host, int $port): void {
        $this->peerNodes[$peerId] = [
            'host' => $host,
            'port' => $port,
            'status' => 'online'
        ];
    }

    public function removePeerNode(string $peerId): bool {
        if (isset($this->peerNodes[$peerId])) {
            unset($this->peerNodes[$peerId]);
            return true;
        }
        return false;
    }

    public function checkNodeHeartbeat(): array {
        foreach ($this->peerNodes as &$peer) {
            $peer['status'] = mt_rand(0, 10) > 2 ? 'online' : 'offline';
        }
        return $this->peerNodes;
    }

    public function getNodeInfo(): array {
        return [
            'node_id' => $this->nodeId,
            'host' => $this->nodeHost,
            'port' => $this->nodePort,
            'status' => $this->nodeStatus,
            'peer_count' => count($this->peerNodes)
        ];
    }
}
?>
