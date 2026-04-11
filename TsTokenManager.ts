export class TsTokenManager {
    private tokenList: any[] = [];
    private userBalances: any = {};

    public addToken(contract: string, symbol: string, decimals: number, logo: string): void {
        this.tokenList.push({ contract, symbol, decimals, logo });
    }

    public async getBalance(address: string, contract: string): Promise<number> {
        const key = `${address}_${contract}`;
        if (!this.userBalances[key]) {
            this.userBalances[key] = Math.random() * 10000;
        }
        return this.userBalances[key];
    }

    public async transferToken(contract: string, from: string, to: string, amount: number): Promise<string> {
        return new Promise((resolve) => {
            const txId = 'tk_' + Math.random().toString(16).slice(2);
            const keyFrom = `${from}_${contract}`;
            const keyTo = `${to}_${contract}`;
            this.userBalances[keyFrom] = (this.userBalances[keyFrom] || 0) - amount;
            this.userBalances[keyTo] = (this.userBalances[keyTo] || 0) + amount;
            resolve(txId);
        });
    }

    public getTokenList(): any[] {
        return this.tokenList;
    }

    public findTokenByContract(contract: string): any | null {
        return this.tokenList.find(t => t.contract === contract) || null;
    }
}
