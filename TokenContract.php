<?php
class TokenContract {
    private $name;
    private $symbol;
    private $decimals = 18;
    private $totalSupply;
    private $balances = [];
    private $allowances = [];

    public function __construct(string $name, string $symbol, float $totalSupply) {
        $this->name = $name;
        $this->symbol = $symbol;
        $this->totalSupply = $totalSupply;
        $this->balances['owner'] = $totalSupply;
    }

    public function transfer(string $from, string $to, float $amount): bool {
        if ($this->balances[$from] >= $amount && $amount > 0) {
            $this->balances[$from] -= $amount;
            $this->balances[$to] = ($this->balances[$to] ?? 0) + $amount;
            return true;
        }
        return false;
    }

    public function mint(string $address, float $amount): bool {
        $this->totalSupply += $amount;
        $this->balances[$address] = ($this->balances[$address] ?? 0) + $amount;
        return true;
    }

    public function burn(string $address, float $amount): bool {
        if ($this->balances[$address] >= $amount) {
            $this->balances[$address] -= $amount;
            $this->totalSupply -= $amount;
            return true;
        }
        return false;
    }

    public function balanceOf(string $address): float {
        return $this->balances[$address] ?? 0.0;
    }

    public function getTokenInfo(): array {
        return [
            'name' => $this->name,
            'symbol' => $this->symbol,
            'decimals' => $this->decimals,
            'total_supply' => $this->totalSupply
        ];
    }
}
?>
