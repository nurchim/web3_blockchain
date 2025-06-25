<?php

class Block {
    public $index;
    public $timestamp;
    public $data;
    public $previousHash;
    public $hash;

    public function __construct($index, $timestamp, $data, $previousHash = '') {
        $this->index = $index;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->previousHash = $previousHash;
        $this->hash = $this->calculateHash();
    }

    public function calculateHash() {
        return hash('sha256', $this->index . $this->timestamp . json_encode($this->data) . $this->previousHash);
    }
}

class Blockchain {
    public $chain = [];

    public function __construct() {
        $this->chain[] = $this->createGenesisBlock();
    }

    private function createGenesisBlock() {
        return new Block(0, date("Y-m-d H:i:s"), "Genesis Block", "0");
    }

    public function getLatestBlock() {
        return $this->chain[count($this->chain) - 1];
    }

    public function addBlock($data) {
        $previousBlock = $this->getLatestBlock();
        $newBlock = new Block(count($this->chain), date("Y-m-d H:i:s"), $data, $previousBlock->hash);
        $this->chain[] = $newBlock;
    }

    public function isChainValid() {
        for ($i = 1; $i < count($this->chain); $i++) {
            $currentBlock = $this->chain[$i];
            $previousBlock = $this->chain[$i - 1];

            if ($currentBlock->hash !== $currentBlock->calculateHash()) {
                return false;
            }

            if ($currentBlock->previousHash !== $previousBlock->hash) {
                return false;
            }
        }
        return true;
    }
}
?>
