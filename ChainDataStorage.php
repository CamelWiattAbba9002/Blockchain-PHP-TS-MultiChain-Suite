<?php
class ChainDataStorage {
    private $storagePath;
    private $blockFile = 'blocks.dat';
    private $txFile = 'transactions.dat';

    public function __construct(string $storagePath = './chain_data/') {
        $this->storagePath = $storagePath;
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
    }

    public function saveBlock(array $block): bool {
        $data = json_encode($block) . PHP_EOL;
        return file_put_contents($this->storagePath . $this->blockFile, $data, FILE_APPEND) !== false;
    }

    public function loadBlocks(): array {
        $blocks = [];
        if (file_exists($this->storagePath . $this->blockFile)) {
            $lines = file($this->storagePath . $this->blockFile, FILE_IGNORE_NEW_LINES);
            foreach ($lines as $line) {
                $block = json_decode($line, true);
                if ($block) $blocks[] = $block;
            }
        }
        return $blocks;
    }

    public function saveTransactions(array $transactions): bool {
        $data = json_encode($transactions) . PHP_EOL;
        return file_put_contents($this->storagePath . $this->txFile, $data, FILE_APPEND) !== false;
    }

    public function backupData(string $backupPath): bool {
        if (!is_dir($backupPath)) mkdir($backupPath, 0755, true);
        copy($this->storagePath . $this->blockFile, $backupPath . 'blocks_backup.dat');
        copy($this->storagePath . $this->txFile, $backupPath . 'transactions_backup.dat');
        return true;
    }
}
?>
