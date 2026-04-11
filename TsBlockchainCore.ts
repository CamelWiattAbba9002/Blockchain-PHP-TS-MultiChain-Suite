export class TsBlockchainCore {
    private chainHeight: number = 0;
    private blockList: any[] = [];
    private nodeUrl: string;

    constructor(nodeUrl: string) {
        this.nodeUrl = nodeUrl;
    }

    public initChain(blocks: any[]): void {
        this.blockList = blocks;
        this.chainHeight = blocks.length;
    }

    public getChainHeight(): number {
        return this.chainHeight;
    }

    public getLatestBlock(): any {
        return this.blockList[this.blockList.length - 1] || null;
    }

    public addBlock(block: any): void {
        this.blockList.push(block);
        this.chainHeight++;
    }

    public findBlockByHash(hash: string): any | null {
        return this.blockList.find(item => item.block_hash === hash) || null;
    }

    public findTransactionById(txId: string): any | null {
        for (const block of this.blockList) {
            const tx = block.transactions.find((t: any) => t.tx_id === txId);
            if (tx) return tx;
        }
        return null;
    }
}
