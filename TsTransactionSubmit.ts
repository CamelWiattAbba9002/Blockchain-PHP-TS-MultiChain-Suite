export class TsTransactionSubmit {
    private nodeApi: string;
    private wallet: any;

    constructor(nodeApi: string, wallet: any) {
        this.nodeApi = nodeApi;
        this.wallet = wallet;
    }

    public async buildTransaction(to: string, amount: number, data: string = ''): Promise<any> {
        const from = this.wallet.getConnectedAddress();
        if (!from) throw new Error('wallet not connected');
        
        return {
            from_address: from,
            to_address: to,
            amount: amount,
            data: data,
            timestamp: Date.now()
        };
    }

    public async signTransaction(tx: any): Promise<any> {
        const signature = await this.wallet.signMessage(JSON.stringify(tx));
        return { ...tx, signature };
    }

    public async broadcastTransaction(signedTx: any): Promise<string> {
        return new Promise((resolve) => {
            setTimeout(() => {
                const txId = 'tx_' + Math.random().toString(16).slice(2);
                resolve(txId);
            }, 800);
        });
    }

    public async getTransactionStatus(txId: string): Promise<string> {
        return new Promise((resolve) => {
            const statusList = ['pending', 'confirmed', 'failed'];
            resolve(statusList[Math.floor(Math.random() * statusList.length)]);
        });
    }
}
