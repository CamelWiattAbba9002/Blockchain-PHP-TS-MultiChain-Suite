export class TsBlockMonitor {
    private core: any;
    private interval: any = null;
    private listeners: Function[] = [];

    constructor(core: any) {
        this.core = core;
    }

    public startMonitor(intervalMs: number = 3000): void {
        this.stopMonitor();
        this.interval = setInterval(() => {
            this.checkNewBlock();
        }, intervalMs);
    }

    public stopMonitor(): void {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    }

    private async checkNewBlock(): void {
        const latest = this.core.getLatestBlock();
        this.listeners.forEach(listener => listener(latest));
    }

    public onNewBlock(callback: (block: any) => void): void {
        this.listeners.push(callback);
    }

    public getMonitorStatus(): boolean {
        return !!this.interval;
    }

    public clearListeners(): void {
        this.listeners = [];
    }
}
