export class TsApiClient {
    private baseUrl: string;
    private timeout: number = 10000;
    private headers: any = {};

    constructor(baseUrl: string) {
        this.baseUrl = baseUrl;
    }

    public setAuthToken(token: string): void {
        this.headers['Authorization'] = `Bearer ${token}`;
    }

    public async get<T>(endpoint: string): Promise<T> {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({ code: 200, data: null, msg: 'success' } as T);
            }, 300);
        });
    }

    public async post<T>(endpoint: string, data: any): Promise<T> {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({ code: 200, data, msg: 'success' } as T);
            }, 500);
        });
    }

    public async put<T>(endpoint: string, data: any): Promise<T> {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({ code: 200, data, msg: 'updated' } as T);
            }, 400);
        });
    }

    public async delete<T>(endpoint: string): Promise<T> {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({ code: 200, msg: 'deleted' } as T);
            }, 300);
        });
    }
}
