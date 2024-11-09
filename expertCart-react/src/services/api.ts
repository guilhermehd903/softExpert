import { BASE_URL } from "../config";

interface RequestOptions {
    method: string;
    headers: Record<string, string>;
    body?: string | FormData;
}

export default class Api {
    response: any = null;
    error: string = "";
    endpoint: string = BASE_URL;
    method: string = "GET";
    body: Record<string, string> | FormData = {};
    header: Record<string, string> = { "Content-Type": "application/json" };

    async req(): Promise<boolean> {
        try {
            const options: RequestOptions = {
                method: this.method,
                headers: this.header
            };

            if (this.method !== "GET") {
                if (this.body instanceof FormData) {
                    delete this.header["Content-Type"];
                    options.body = this.body;
                } else {
                    options.body = JSON.stringify(this.body);
                }
            }

            const response = await fetch(this.endpoint, options);
            const data = await response.json();

            if (data.error) {
                this.error = data.msg;
                alert(this.error);
            }

            this.response = data;

            return true;
        } catch (error) {
            console.log(error);
            this.error = (error as Error).message;
            return false;
        }
    }

    setEndpoint(endpoint: string) {
        console.log(endpoint);
        this.endpoint = BASE_URL + endpoint;
    }

    addHeader(newHeader: Record<string, string>) {
        this.header = { ...this.header, ...newHeader };
    }
}
