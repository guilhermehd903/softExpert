import { useEffect, useState } from "react"
import { InfoCard } from "../../components/infocard"
import { Metric } from "../../components/metric"
import { Main } from "./style"

import { useNavigate } from "react-router"
import { removeItem } from "../../utils/storage"
import { Loading } from "../../components/loading"
import { getvendasme } from "../../services/Vendas"
import { getUser } from "../../services/Usuario"

export const Caixa = () => {
    const nav = useNavigate();
    const [user, setUser] = useState<any>();

    const [loading, setloading] = useState(true);
    const [sell, setSell] = useState([]);

    const [total, setTotal] = useState("");

    const fetchVendas = async () => {
        const req = await getvendasme();

        if (req) {
            setSell(req.response.data);
            console.log(req.response.data);
            const total = req.response.data.reduce((count, current) => count + current.total, 0);
            setTotal(total);
        }

        setloading(false);
    }

    useEffect(() => {
        userInfo();
        fetchVendas();
    }, []);

    const userInfo = async () => {
        setloading(true);
        const info = await getUser();

        if (!info) {
            removeItem("session");
            nav("/");
            return;
        }

        setUser(info.response.data);
    }

    return (!loading) ? (
        <Main>
            <h1>Seja bem vindo, {user.nome}</h1>
            <p>Utilize o menu lateral para acessar funcionalidades.</p>
            <br />
            <br />
            <br />
            <div className="info-card-list">
                <InfoCard value={total}/>
            </div>
            <br />
            <br />
            <div className="metrics">
                <Metric list={sell} />
            </div>
        </Main>
    ) : (
        <Loading />
    )
}