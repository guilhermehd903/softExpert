import { getItem } from "../utils/storage"
import Api from "./api";

export const getProdutos = async () => {
    const token = getItem("session");

    if (!token) return false;

    const req = new Api();
    req.setEndpoint("/produtos");
    req.method = "GET";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const registerProduto = async (nome: string, preco: string, descricao: string, categoria_id: string, foto: any) => {
    const token = getItem("session");

    if (!token) return false;

    const req = new Api();
    req.setEndpoint("/produto");
    req.method = "POST";

    const form = new FormData();
    form.append("nome", nome);
    form.append("preco", preco);
    form.append("descricao", descricao);
    form.append("categoria_id", categoria_id);
    form.append("foto", foto);

    req.body = form;
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}

export const deleteProduto = async (id: string) => {
    const token = getItem("session");

    if (!token) return false;

    const req = new Api();
    req.setEndpoint("/produto/" + id);
    req.method = "DELETE";
    req.addHeader({ "Authorization": `Bearer ${token}` });
    await req.req();

    return req;
}