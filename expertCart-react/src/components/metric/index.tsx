import { useState } from "react";
import { Container } from "./style"
import { getItem } from "../../utils/storage";
import { formatCurrency, formatDate } from "../../utils/functions";


interface MetricProps {
    list: any;
}

export const Metric = ({ list }: MetricProps) => {
    const [role] = useState(getItem("role"));

    return (
        <Container>
            <h1>Ultimas vendas</h1>
            <table>
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
                    {(list && list.length > 0) ? list.map((item: any) => (
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
            </table>
        </Container>
    )
}