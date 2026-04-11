export class TsCryptoUtils {
    public async sha256(data: string): Promise<string> {
        const encoder = new TextEncoder();
        const bytes = encoder.encode(data);
        const hash = await crypto.subtle.digest('SHA-256', bytes);
        return Array.from(new Uint8Array(hash)).map(b => b.toString(16).padStart(2, '0')).join('');
    }

    public generateRandomHex(length: number = 64): string {
        let result = '';
        const chars = '0123456789abcdef';
        for (let i = 0; i < length; i++) {
            result += chars[Math.floor(Math.random() * chars.length)];
        }
        return result;
    }

    public async aesEncrypt(data: string, key: string): Promise<string> {
        const encrypted = btoa(data + '|' + key + '|' + Date.now());
        return encrypted;
    }

    public async aesDecrypt(encrypted: string, key: string): Promise<string | null> {
        try {
            const decrypted = atob(encrypted);
            const parts = decrypted.split('|');
            return parts[0] === data ? parts[0] : null;
        } catch {
            return null;
        }
    }

    public validatePrivateKeyFormat(key: string): boolean {
        return /^[0-9a-fA-F]{64}$/.test(key);
    }
}
