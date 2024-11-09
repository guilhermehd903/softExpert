import { Button, Container, Cover, Form } from "./style"
import logo from "../../assets/logo.svg";
import { useState } from "react";
import { Input } from "../../components/input";
import { getVendaByCpf } from "../../services/Vendas";
import { formatCurrency, formatDate } from "../../utils/functions";
import { BASE_URL } from "../../config";

export const CPF = () => {
    const [loading, setLoading] = useState(false);

    const [cpf, setcpf] = useState("");

    const [sell, setsell] = useState<any>();
    const [sellList, setsellList] = useState([]);

    const fetchvenda = async () => {
        setLoading(true);
        const cpfFilter = cpf.trim().replace(/[.-]/g, '');
        const req = await getVendaByCpf(cpfFilter);

        if (req) {
            setsell(req.response.data);

            const tags = req.response.data.produtos.map(t => t.categoria_id).filter((value, index, self) => self.indexOf(value) === index);

            const list = [];

            for (const item of tags) {
                const prodList = req.response.data.produtos.filter(p => p.categoria_id === item);
                list.push({
                    title: prodList[0].categoria.nome,
                    prods: prodList
                });
            }

            setsellList(list);

            console.log(list);
        }

        setLoading(false);
    }

    return (
        <Container>
            <Cover>
                <h1>CPF na nota</h1>
                <p>Entre com seu CPF no campo abaixo para pesquisar ultima compra</p><br />
                <Input label="CPF" placeholder="ex: 123.123.123-12" set={setcpf} value={cpf} />
                <Button onClick={fetchvenda} disabled={loading}>Entrar</Button>
            </Cover>
            <Form>
                {sell && (
                    <div className="container">
                        <img src={logo} alt="logo" width="200" />
                        <h1>Pedido #{sell.id}</h1>
                        <div className="details">
                            <div className="item">
                                <b>Pagamento: </b>
                                <span>{sell.metodo}</span>
                            </div>
                            <div className="item">
                                <b>Data: </b>
                                <span>{formatDate(sell.created_at)}</span>
                            </div>
                        </div>
                        <div className="list">
                            {sellList.map((item) => (
                                <>
                                    <h2 className="title">{item.title}</h2>
                                    {item.prods.map((prod) => (
                                        <div className="itens">
                                            <div className="item">
                                                <img src={BASE_URL+"/"+prod.img} alt="logo" width="50" />
                                                <div className="info">
                                                    <h3>{prod.nome}</h3>
                                                    <p>{prod.desc}</p>
                                                </div>
                                                <h4><small>x{prod.qtd}</small>&nbsp;&nbsp;{formatCurrency(prod.total)}</h4>
                                            </div>
                                        </div>
                                    ))
                                    }
                                </>
                            ))
                            }

                        </div>
                    </div>
                )
                }
            </Form>
        </Container>
    )
}