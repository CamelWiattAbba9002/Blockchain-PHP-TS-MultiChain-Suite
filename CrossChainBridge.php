<?php
class CrossChainBridge {
    private $supportedChains = [];
    private $crossChainRecords = [];

    public function addChain(string $chainId, string $chainName, string $rpcUrl): void {
        $this->supportedChains[$chainId] = [
            'name' => $chainName,
            'rpc_url' => $rpcUrl,
            'status' => 'active'
        ];
    }

    public function createCrossChainOrder(string $fromChain, string $toChain, string $fromAddress, string $toAddress, float $amount): string {
        $orderId = hash('sha256', uniqid($fromChain . $toChain . $amount, true));
        $this->crossChainRecords[$orderId] = [
            'order_id' => $orderId,
            'from_chain' => $fromChain,
            'to_chain' => $toChain,
            'from_address' => $fromAddress,
            'to_address' => $toAddress,
            'amount' => $amount,
            'status' => 'pending',
            'create_time' => time()
        ];
        return $orderId;
    }

    public function updateOrderStatus(string $orderId, string $status): bool {
        if (isset($this->crossChainRecords[$orderId])) {
            $this->crossChainRecords[$orderId]['status'] = $status;
            $this->crossChainRecords[$orderId]['update_time'] = time();
            return true;
        }
        return false;
    }

    public function getOrderInfo(string $orderId): ?array {
        return $this->crossChainRecords[$orderId] ?? null;
    }

    public function getSupportedChains(): array {
        return $this->supportedChains;
    }
}
?>
