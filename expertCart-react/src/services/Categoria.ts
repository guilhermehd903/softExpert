import { getItem } from "../utils/storage"
import Api from "./api";

export const getCategorias = async () => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/categorias");
    req.method = "GET";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const registerCategoria = async (nome: string, imposto: string) => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/categoria");
    req.method = "POST";
    req.body = {nome, imposto};
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const deleteCategoria = async (id: string) => {
    const token = getItem("session");
    
    if (!token) return false;
    
    const req = new Api();
    req.setEndpoint("/categoria/"+id);
    req.method = "DELETE";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}