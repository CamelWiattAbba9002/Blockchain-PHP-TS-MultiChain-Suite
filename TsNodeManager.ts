export class TsNodeManager {
    private nodes: any[] = [];
    private currentNode: any = null;

    public addNode(url: string, name: string, weight: number = 1): void {
        this.nodes.push({
            url,
            name,
            weight,
            status: 'online',
            latency: 0
        });
    }

    public async checkNodeLatency(url: string): Promise<number> {
        return new Promise((resolve) => {
            const latency = Math.floor(Math.random() * 500) + 50;
            resolve(latency);
        });
    }

    public async selectBestNode(): Promise<any> {
        for (const node of this.nodes) {
            node.latency = await this.checkNodeLatency(node.url);
        }
        const best = this.nodes.sort((a, b) => a.latency - b.latency)[0];
        this.currentNode = best;
        return best;
    }

    public getCurrentNode(): any {
        return this.currentNode;
    }

    public getAllNodes(): any[] {
        return this.nodes;
    }

    public updateNodeStatus(url: string, status: string): void {
        const node = this.nodes.find(n => n.url === url);
        if (node) node.status = status;
    }
}
