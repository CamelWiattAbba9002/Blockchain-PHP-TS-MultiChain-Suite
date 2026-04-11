export class TsLocalStorage {
    private prefix: string = 'blockchain_';

    public setItem(key: string, value: any): void {
        try {
            const data = JSON.stringify(value);
            localStorage.setItem(this.prefix + key, data);
        } catch (e) {
            console.error('Local storage save failed', e);
        }
    }

    public getItem<T>(key: string): T | null {
        try {
            const data = localStorage.getItem(this.prefix + key);
            if (!data) return null;
            return JSON.parse(data) as T;
        } catch {
            return null;
        }
    }

    public removeItem(key: string): void {
        localStorage.removeItem(this.prefix + key);
    }

    public clearAll(): void {
        const keys = [];
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key && key.startsWith(this.prefix)) {
                keys.push(key);
            }
        }
        keys.forEach(k => localStorage.removeItem(k));
    }

    public hasKey(key: string): boolean {
        return !!localStorage.getItem(this.prefix + key);
    }
}
