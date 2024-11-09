import { Main } from "./style"
import { Input } from "../../components/input"
import { HeaderList } from "../../components/headerList"
import { ListTable } from "../../components/listTable"
import { ListForm } from "../../components/listForm"
import { useEffect, useState } from "react"
import { Select } from "../../components/select"
import { deleteUser, getAll, registerUser } from "../../services/Usuario"
import { Loading } from "../../components/loading"

export const Usuarios = () => {
    const [loading, setloading] = useState(false);
    const roles = [{ id: "caixa", nome: " Operador caixa" }, { id: "admin", nome: "Gerente" }];
    const [funcs, setFuncs] = useState<any>([]);

    const [nome, setnome] = useState<any>("");
    const [email, setemail] = useState<any>("");
    const [cpf, setcpf] = useState<any>("");
    const [nasc, setnasc] = useState<any>("");
    const [role, setrole] = useState<any>("");


    const register = async () => {
        setloading(true);
        const req = await registerUser(nome, email, cpf, nasc, role);

        if (req) {
            setnome("");
            setemail("");
            setcpf("");
            setnasc("");
            fetchFuncs();
        }

        setloading(false);
    }

    const fetchFuncs = async () => {
        setloading(true);
        const req = await getAll();

        if (req) {
            setFuncs(req.response.data);
        }
        setloading(false);
    }

    const removeUser = async (id: string) => {
        const confirm = window.confirm("Tem certeza que deseja excluir?");

        if (confirm) {
            const req = await deleteUser(id);

            if (req) {
                const refresh = funcs.filter((c: any) => c.id !== id);
                setFuncs(refresh);
            }
        }
    }

    useEffect(() => {
        fetchFuncs();
    }, []);

    return (

        <Main>
            {loading ? <Loading /> : null}
            <HeaderList title="Gerenciamento de funcionarios" desc="Adicione, remova funcionarios" />
            <div className="workspace">
                <ListTable>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Cargo</th>
                            <th>Acesso</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        {(funcs && funcs.length > 0) ? funcs.map((item: any) => (
                            <tr>
                                <td>{item.id}</td>
                                <td>{item.nome}</td>
                                <td>{item.cpf}</td>
                                <td>{item.role}</td>
                                <td>{item.access}</td>
                                <td><button onClick={() => removeUser(item.id)} className="btnDel">Remover</button></td>
                            </tr>
                        )) : null}
                    </tbody>
                </ListTable>
                <ListForm title="Adicione um funcionario" call={register} loading={loading}>
                    <Input label="Nome" placeholder="Informe nome" value={nome} set={setnome} />
                    <Input label="Email" placeholder="Informe email" value={email} set={setemail} />
                    <Input label="cpf" placeholder="Informe preço" value={cpf} set={setcpf} />
                    <Input label="Nascimento" type="date" placeholder="Informe preço" value={nasc} set={setnasc} />
                    <Select list={roles} set={setrole} />
                </ListForm>
            </div>
        </Main>
    )
}