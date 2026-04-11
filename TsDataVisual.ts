export class TsDataVisual {
    public generateBlockChartData(blocks: any[]): any {
        return {
            labels: blocks.map((_, i) => `#${i + 1}`),
            datasets: [{
                label: 'Block Height',
                data: blocks.map(b => b.height || 0),
                color: '#1e88e5'
            }]
        };
    }

    public generateTransactionChartData(blocks: any[]): any {
        return {
            labels: blocks.map((_, i) => `Block ${i + 1}`),
            datasets: [{
                label: 'Transaction Count',
                data: blocks.map(b => b.transactions?.length || 0),
                color: '#43a047'
            }]
        };
    }

    public generateHashRateData(days: number = 7): any {
        return {
            labels: Array.from({ length: days }, (_, i) => `Day ${i + 1}`),
            datasets: [{
                label: 'Hash Rate (TH/s)',
                data: Array.from({ length: days }, () => Math.random() * 1000 + 500),
                color: '#e53935'
            }]
        };
    }

    public formatNumber(num: number): string {
        if (num >= 1000000) return (num / 1000000).toFixed(2) + 'M';
        if (num >= 1000) return (num / 1000).toFixed(2) + 'K';
        return num.toFixed(2);
    }
}
