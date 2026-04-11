export class TsWalletConnector {
    private connectedAddress: string | null = null;
    private walletName: string = '';

    public async connectWallet(walletType: 'metamask' | 'walletconnect'): Promise<string> {
        return new Promise((resolve) => {
            setTimeout(() => {
                const address = '0x' + Math.random().toString(16).slice(2, 42);
                this.connectedAddress = address;
                this.walletName = walletType;
                resolve(address);
            }, 500);
        });
    }

    public disconnectWallet(): void {
        this.connectedAddress = null;
        this.walletName = '';
    }

    public getConnectedAddress(): string | null {
        return this.connectedAddress;
    }

    public getWalletInfo(): any {
        return {
            address: this.connectedAddress,
            type: this.walletName,
            connected: !!this.connectedAddress
        };
    }

    public async signMessage(message: string): Promise<string> {
        return new Promise((resolve) => {
            const signature = '0x' + btoa(message + this.connectedAddress + Date.now());
            resolve(signature);
        });
    }
}
