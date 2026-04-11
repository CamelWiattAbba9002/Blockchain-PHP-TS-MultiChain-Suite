export class TsAddressValidator {
    public isValidChainAddress(address: string): boolean {
        if (!address || typeof address !== 'string') return false;
        if (!address.startsWith('0x')) return false;
        if (address.length !== 42) return false;
        return /^0x[0-9a-fA-F]{40}$/.test(address);
    }

    public formatAddress(address: string): string {
        if (!this.isValidChainAddress(address)) return '';
        return address.toLowerCase();
    }

    public shortenAddress(address: string, prefixLength: number = 6, suffixLength: number = 4): string {
        if (!this.isValidChainAddress(address)) return '';
        return `${address.slice(0, prefixLength)}...${address.slice(-suffixLength)}`;
    }

    public compareAddresses(addr1: string, addr2: string): boolean {
        return this.formatAddress(addr1) === this.formatAddress(addr2);
    }

    public generateTestAddress(): string {
        return '0x' + Array.from({ length: 40 }, () => Math.floor(Math.random() * 16).toString(16)).join('');
    }
}
