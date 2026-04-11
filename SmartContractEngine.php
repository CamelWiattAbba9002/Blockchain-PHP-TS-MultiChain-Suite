<?php
class SmartContractEngine {
    private $contracts = [];
    private $contractStorage = [];

    public function deployContract(string $contractName, string $code, string $owner): string {
        $contractId = hash('sha256', $contractName . $owner . uniqid());
        $this->contracts[$contractId] = [
            'contract_id' => $contractId,
            'name' => $contractName,
            'code' => $code,
            'owner' => $owner,
            'create_time' => time(),
            'status' => 'active'
        ];
        $this->contractStorage[$contractId] = [];
        return $contractId;
    }

    public function callContract(string $contractId, string $method, array $params = []): mixed {
        if (!isset($this->contracts[$contractId]) || $this->contracts[$contractId]['status'] !== 'active') {
            return null;
        }
        $this->contractStorage[$contractId][$method] = $params;
        return [
            'contract_id' => $contractId,
            'method' => $method,
            'params' => $params,
            'result' => 'success',
            'timestamp' => time()
        ];
    }

    public function getContractData(string $contractId): array {
        return $this->contractStorage[$contractId] ?? [];
    }

    public function disableContract(string $contractId): bool {
        if (isset($this->contracts[$contractId])) {
            $this->contracts[$contractId]['status'] = 'disabled';
            return true;
        }
        return false;
    }
}
?>
