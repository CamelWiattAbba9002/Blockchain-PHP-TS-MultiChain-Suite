export class TsCrossChainHandler {
    private fromChain: string = '';
    private toChain: string = '';
    private orders: any[] = [];

    public setChains(from: string, to: string): void {
        this.fromChain = from;
        this.toChain = to;
    }

    public async createCrossOrder(fromAddr: string, toAddr: string, amount: number): Promise<string> {
        return new Promise((resolve) => {
            const orderId = 'cc_' + Math.random().toString(16).slice(2);
            this.orders.push({
                orderId,
                fromChain: this.fromChain,
                toChain: this.toChain,
                fromAddr,
                toAddr,
                amount,
                status: 'pending',
                createTime: Date.now()
            });
            resolve(orderId);
        });
    }

    public async getOrderStatus(orderId: string): Promise<string> {
        const order = this.orders.find(o => o.orderId === orderId);
        if (!order) return 'not_found';
        const status = ['pending', 'processing', 'completed', 'failed'];
        return status[Math.floor(Math.random() * status.length)];
    }

    public getUserOrders(address: string): any[] {
        return this.orders.filter(o => o.fromAddr === address || o.toAddr === address);
    }

    public getChainPair(): any {
        return { from: this.fromChain, to: this.toChain };
    }
}
