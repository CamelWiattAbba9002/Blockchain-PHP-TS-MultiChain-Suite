export class TsContractCaller {
    private contractAddress: string;
    private abi: any[];
    private apiClient: any;

    constructor(contractAddress: string, abi: any[], apiClient: any) {
        this.contractAddress = contractAddress;
        this.abi = abi;
        this.apiClient = apiClient;
    }

    public async callMethod(method: string, params: any[] = []): Promise<any> {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({
                    contract: this.contractAddress,
                    method,
                    params,
                    result: 'success',
                    timestamp: Date.now()
                });
            }, 600);
        });
    }

    public async sendTransaction(method: string, params: any[] = [], value: number = 0): Promise<string> {
        return new Promise((resolve) => {
            const txId = 'ct_' + Math.random().toString(16).slice(2);
            resolve(txId);
        });
    }

    public getContractInfo(): any {
        return {
            address: this.contractAddress,
            abi_length: this.abi.length
        };
    }

    public async getContractState(): Promise<any> {
        return {
            contract: this.contractAddress,
            state: 'active',
            updated_at: Date.now()
        };
    }
}
