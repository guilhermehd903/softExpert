import { Main } from "./style"
import { HeaderList } from "../../components/headerList"
import { ListTable } from "../../components/listTable"
import { useEffect, useState } from "react";
import { getvendasme } from "../../services/Vendas";
import { formatCurrency, formatDate } from "../../utils/functions";
import { Loading } from "../../components/loading";
import { getItem } from "../../utils/storage";

export const VendasLista = () => {
    const [role] = useState(getItem("role"));

    const [loading, setloading] = useState(false);
    const [sell, setSell] = useState([]);

    const fetchVendas = async () => {
        setloading(true);
        const req = await getvendasme();

        if (req) {
            setSell(req.response.data);
        }

        setloading(false);
    }

    useEffect(() => {
        fetchVendas();
    }, []);
    return (

        <Main>
            {loading ? <Loading /> : null}
            <HeaderList title="Listagem de vendas" desc="Acompanhe o historico de vendas atualizadas" />
            <div className="workspace">
                <ListTable>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CPF</th>
                            <th>Realido em</th>
                            <th>Metodo</th>
                            {role === "admin" && <th>Caixa</th>}
                            <th>Subtotal</th>
                            <th>Imposto</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {(sell && sell.length > 0) ? sell.map((item: any) => (
                            <tr>
                                <td>{item.id}</td>
                                <td>{item.cpf}</td>
                                <td>{formatDate(item.created_at)}</td>
                                <td>{item.metodo}</td>
                                {role === "admin" && <td>{item.vendedor.nome}</td>}
                                <td>{formatCurrency(item.subtotal)}</td>
                                <td>{formatCurrency(item.imposto)}</td>
                                <td>{formatCurrency(item.total)}</td>
                            </tr>
                        )) : null}
                    </tbody>
                </ListTable>
            </div>
        </Main>
    )
}