export class TsErrorHandler {
    private errorLog: any[] = [];
    private maxLogSize = 100;

    public catchError(error: any, module: string): void {
        const errorItem = {
            module,
            message: error.message || 'unknown error',
            stack: error.stack || '',
            time: Date.now()
        };
        this.errorLog.unshift(errorItem);
        if (this.errorLog.length > this.maxLogSize) {
            this.errorLog.pop();
        }
        this.reportError(errorItem);
    }

    private reportError(error: any): void {
        console.warn('[Blockchain Error]', error.module, error.message);
    }

    public getErrorLogs(): any[] {
        return this.errorLog;
    }

    public clearErrors(): void {
        this.errorLog = [];
    }

    public createUserFriendlyError(error: any): string {
        if (error.message.includes('wallet')) return 'Please connect your wallet first';
        if (error.message.includes('address')) return 'Invalid blockchain address format';
        if (error.message.includes('network')) return 'Network error, please try again later';
        return 'Operation failed, please refresh and try again';
    }
}
