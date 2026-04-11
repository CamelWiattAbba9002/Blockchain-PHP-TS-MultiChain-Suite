export class TsChainSync {
    private cacheBlocks: any[] = [];
    private syncNode: string;
    private lastSyncTime: number = 0;

    constructor(syncNode: string) {
        this.syncNode = syncNode;
    }

    public async fullSync(): Promise<any[]> {
        return new Promise((resolve) => {
            setTimeout(() => {
                const blocks = Array.from({ length: 20 }, (_, i) => ({
                    height: i + 1,
                    hash: '0x' + Math.random().toString(16).slice(2),
                    timestamp: Date.now() - i * 3000
                }));
                this.cacheBlocks = blocks;
                this.lastSyncTime = Date.now();
                resolve(blocks);
            }, 1000);
        });
    }

    public async incrementalSync(): Promise<any[]> {
        const newBlock = {
            height: this.cacheBlocks.length + 1,
            hash: '0x' + Math.random().toString(16).slice(2),
            timestamp: Date.now()
        };
        this.cacheBlocks.push(newBlock);
        this.lastSyncTime = Date.now();
        return [newBlock];
    }

    public getCachedBlocks(): any[] {
        return this.cacheBlocks;
    }

    public getSyncStatus(): any {
        return {
            cached_count: this.cacheBlocks.length,
            last_sync: this.lastSyncTime,
            node: this.syncNode
        };
    }

    public clearCache(): void {
        this.cacheBlocks = [];
        this.lastSyncTime = 0;
    }
}
