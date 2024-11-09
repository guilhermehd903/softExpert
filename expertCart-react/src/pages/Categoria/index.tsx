import { Main } from "./style"
import { Input } from "../../components/input"
import { HeaderList } from "../../components/headerList"
import { ListTable } from "../../components/listTable"
import { ListForm } from "../../components/listForm"
import { useEffect, useState } from "react"
import { deleteCategoria, getCategorias, registerCategoria } from "../../services/Categoria"
import { Loading } from "../../components/loading"

export const Categoria = () => {
    const [loading, setloading] = useState(false);
    const [categorias, setcategorias] = useState([]);

    const [nome, setnome] = useState<string>("");
    const [imposto, setimposto] = useState<string>("");

    const fetchcategorias = async () => {
        setloading(true);
        const req = await getCategorias();

        if (req) {
            setcategorias(req.response.data);
        }
        setloading(false);
    }

    const register = async (event) => {
        event.preventDefault();
        setloading(true);

        const req = await registerCategoria(nome, imposto);

        if(req){
            await fetchcategorias();
            setnome("");
            setimposto("");
        }
        setloading(false);
    }

    const delCategoria = async (id:string)=>{
        const confirm = window.confirm("Tem certeza que deseja excluir?");

        if(confirm){
            const req = await deleteCategoria(id);

            if(req){
                const refresh = categorias.filter((c:any) => c.id !== id);
                setcategorias(refresh);
            }
        }
    }

    useEffect(() => {
        if (categorias.length == 0) {
            fetchcategorias();
        }
    }, [categorias]);

    return (
        <Main>
            {loading ? <Loading /> : null}
            <HeaderList title="Gerenciamento de categorias" desc="Adicione, remova categorias" />
            <div className="workspace">
                <ListTable>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Imposto</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        {(categorias && categorias.length > 0) ? categorias.map((item:any) => (
                            <tr>
                                <td>{item.id}</td>
                                <td>{item.nome}</td>
                                <td>{item.imposto}</td>
                                <td onClick={() => delCategoria(item.id)}><button className="btnDel">Remover</button></td>
                            </tr>
                        )) : null}
                    </tbody>
                </ListTable>
                <ListForm title="Adicione uma categoria" call={register} loading={loading}>
                    <Input label="Nome" placeholder="Informe nome" value={nome} set={setnome}/>
                    <Input label="Imposto" type="number" placeholder="Informe imposto" value={imposto} set={setimposto}/>
                </ListForm>
            </div>
        </Main>
    )
}