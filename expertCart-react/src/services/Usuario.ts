import { getItem } from "../utils/storage"
import Api from "./api";

export const getUser = async () => {
    const token = getItem("session");

    if (!token) return false;

    const req = new Api();
    req.setEndpoint("/me");
    req.method = "GET";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const registerUser = async (nome: string, email: string, cpf: string, nasc: string, role: string) => {
    const token = getItem("session");

    if (!token) return false;

    const req = new Api();
    req.setEndpoint("/usuario");
    req.method = "POST";
    req.body = { nome, cpf, email, nasc, role };
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const editUser = async (nome: string, email: string, cpf: string, photo: string, id: string) => {
    const token = getItem("session");

    if (!token) return false;

    const req = new Api();
    req.setEndpoint("/usuario/"+id);
    req.method = "PUT";
    
    req.body = { nome, cpf, email, foto:photo };

    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const deleteUser = async (id: string) => {
    const token = getItem("session");

    if (!token) return false;

    const req = new Api();
    req.setEndpoint("/usuario/"+id);
    req.method = "DELETE";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const getAll = async () => {
    const token = getItem("session");

    if (!token) return false;

    const req = new Api();
    req.setEndpoint("/usuarios");
    req.method = "GET";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}