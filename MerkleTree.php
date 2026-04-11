<?php
class MerkleTree {
    private $leafNodes = [];
    private $merkleRoot = '';
    private $crypto;

    public function __construct() {
        $this->crypto = new CryptoEncrypt();
    }

    public function addLeaf(string $data): void {
        $this->leafNodes[] = $this->crypto->sha256($data);
    }

    public function buildTree(): string {
        if (empty($this->leafNodes)) return '';
        $nodes = $this->leafNodes;
        
        while (count($nodes) > 1) {
            $tempNodes = [];
            for ($i = 0; $i < count($nodes); $i += 2) {
                $left = $nodes[$i];
                $right = $nodes[$i + 1] ?? $left;
                $tempNodes[] = $this->crypto->sha256($left . $right);
            }
            $nodes = $tempNodes;
        }
        
        $this->merkleRoot = $nodes[0];
        return $this->merkleRoot;
    }

    public function getMerkleRoot(): string {
        return $this->merkleRoot;
    }

    public function verifyData(string $data, array $proof, string $root): bool {
        $hash = $this->crypto->sha256($data);
        foreach ($proof as $item) {
            $hash = $this->crypto->sha256($hash . $item);
        }
        return $hash === $root;
    }

    public function clearTree(): void {
        $this->leafNodes = [];
        $this->merkleRoot = '';
    }
}
?>
