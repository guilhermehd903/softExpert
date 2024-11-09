import { getItem } from "../utils/storage"
import Api from "./api";

export const getvendas = async () => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/vendas");
    req.method = "GET";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const getvendasme = async () => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/vendas/me");
    req.method = "GET";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const getVendaByCpf = async (cpf:string) => {
    const req = new Api();
    req.setEndpoint("/venda/cpf/"+cpf);
    req.method = "GET";
    await req.req();

    return req;
}


export const getvendasOpen = async () => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/venda/status/aberta");
    req.method = "GET";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const editVenda = async (cpf:string, metodo:string, id:string) => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/venda/"+id);
    req.method = "PUT";
    req.body = {cpf, metodo, open:"0"};
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const registerProdutoToCart = async (prodID:string, qtd: string) => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/venda/status/aberta/"+prodID);
    req.method = "POST";
    req.body = {qtd};
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const editProdFromCart = async (id: string, qtd: string) => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/venda/status/aberta/"+id);
    req.method = "PUT";
    req.body = {qtd};
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const delProdFromCart = async (id: string) => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/venda/status/aberta/"+id);
    req.method = "DELETE";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}