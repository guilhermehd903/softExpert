import Api from "./api";

export const authLogin = async (code: string) => {
    const req = new Api();

    req.setEndpoint("/auth");
    req.method = "POST";
    req.body = { code };
    await req.req();

    return req;
}