import { Main } from "./style"
import { Input } from "../../components/input"
import { HeaderList } from "../../components/headerList"
import { ListTable } from "../../components/listTable"
import { ListForm } from "../../components/listForm"
import { useEffect, useState } from "react"
import { deleteProduto, getProdutos, registerProduto } from "../../services/Produtos"
import { Select } from "../../components/select"
import { getCategorias } from "../../services/Categoria"
import { File } from "../../components/file"
import { Loading } from "../../components/loading"
import { getItem } from "../../utils/storage"

export const Produtos = () => {
    const [role] = useState(getItem("role"));

    const [loading, setloading] = useState(false);
    const [products, setproducts] = useState([]);
    const [categorias, setcategorias] = useState([]);

    const [nome, setnome] = useState<string>("");
    const [preco, setpreco] = useState<string>("");
    const [descricao, setdescricao] = useState<string>("");
    const [categoriaId, setCategoriaId] = useState<string>("");
    const [file, setFile] = useState<any>();

    const fetchProducts = async () => {
        setloading(true);
        const req = await getProdutos();

        if (req) {
            setproducts(req.response.data);
        }
        setloading(false);
    }

    const fetchcategorias = async () => {
        const req = await getCategorias();

        if (req) {
            setcategorias(req.response.data);
        }
    }

    const register = async (event: any) => {
        event.preventDefault();
        setloading(true);

        const photo = (file) ? file[0] : null;

        const req = await registerProduto(nome, preco, descricao, categoriaId, photo);

        if (req) {
            await fetchProducts();
            setnome("");
            setpreco("");
            setdescricao("");
        }

        setloading(false);
    }

    const delProduto = async (id: string) => {
        const confirm = window.confirm("Tem certeza que deseja excluir?");

        if (confirm) {
            const req = await deleteProduto(id);

            if (req) {
                const refresh = products.filter((c: any) => c.id !== id);
                setproducts(refresh);
            }
        }
    }

    useEffect(() => {
        if (products.length == 0) {
            fetchProducts();
        }
    }, [products]);

    useEffect(() => {
        if (categorias.length == 0) {
            fetchcategorias();
        }
    }, [categorias]);

    return (
        <Main>
            {loading ? <Loading /> : null}
            <HeaderList title="Gerenciamento de produtos" desc="Adicione, remova produtos" />
            <div className="workspace" style={{ gridTemplateColumns: (role == "admin") ? "70% auto" : "auto" }}>
                <ListTable>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Categoria</th>
                            {role == "admin" && <th>Remover</th>}
                        </tr>
                    </thead>
                    <tbody>
                        {(products && products.length > 0) ? products.map((item: any) => (
                            <tr>
                                <td>{item.id}</td>
                                <td>{item.nome}</td>
                                <td>{item.preco}</td>
                                <td>{item.categoria_id}</td>
                                {role == "admin" && (
                                    <td><button onClick={() => delProduto(item.id)} className="btnDel">Remover</button></td>
                                )
                                }
                            </tr>
                        )) : null}
                    </tbody>
                </ListTable>
                {role == "admin" && (
                    <ListForm title="Adicione um produto" call={register} loading={loading}>
                        <Input label="Nome" placeholder="Informe nome" value={nome} set={setnome} />
                        <Input label="Preco" placeholder="Informe preço" value={preco} set={setpreco} />
                        <Input label="Descrição" placeholder="Informe descricao" value={descricao} set={setdescricao} />
                        <Select list={categorias} set={setCategoriaId} />
                        <File set={setFile} label="Foto" />
                    </ListForm>
                )}
            </div>
        </Main>
    )
}