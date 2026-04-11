<?php
class TransactionCore {
    private $pendingTransactions = [];
    private $chainId;

    public function __construct(string $chainId) {
        $this->chainId = $chainId;
    }

    public function createTransaction(string $from, string $to, float $amount, string $data = ''): string {
        $txId = hash('sha256', uniqid($from . $to . $amount, true));
        $this->pendingTransactions[$txId] = [
            'tx_id' => $txId,
            'from_address' => $from,
            'to_address' => $to,
            'amount' => $amount,
            'data' => $data,
            'timestamp' => time(),
            'status' => 'pending'
        ];
        return $txId;
    }

    public function signTransaction(string $txId, string $privateKey): bool {
        if (!isset($this->pendingTransactions[$txId])) return false;
        $this->pendingTransactions[$txId]['signature'] = hash('sha256', $txId . $privateKey);
        $this->pendingTransactions[$txId]['status'] = 'signed';
        return true;
    }

    public function broadcastTransaction(string $txId): bool {
        if (isset($this->pendingTransactions[$txId]) && $this->pendingTransactions[$txId]['status'] === 'signed') {
            $this->pendingTransactions[$txId]['status'] = 'broadcasted';
            return true;
        }
        return false;
    }

    public function getPendingTransactions(): array {
        return array_values($this->pendingTransactions);
    }

    public function clearPendingTransactions(): void {
        $this->pendingTransactions = [];
    }
}
?>
