import { GoHome } from "react-icons/go"
import { Container, LogoutButton, MenuItem } from "./style"
import { FiShoppingCart, FiUser } from "react-icons/fi"
import { LiaCartPlusSolid } from "react-icons/lia"
import { FaTag, FaUserPlus } from "react-icons/fa"
import { CiLogout } from "react-icons/ci"
import { getItem, removeItem } from "../../utils/storage"
import { useNavigate } from "react-router"
import { AiFillProduct } from "react-icons/ai"
import { useEffect, useState } from "react"

interface MenuProps {
    active?: string;
}

export const Menu = ({ active }: MenuProps) => {
    const [role, setRole] = useState("");
    const nav = useNavigate();

    const logOff = () => {
        const confirm = window.confirm('Tem certeza que deseja sair?');

        if (confirm && removeItem("session")) {
            nav("/");
        }
    }

    useEffect(() => {
        if (role == "") {
            setRole(getItem("role"));
        }
    }, []);

    return (
        <Container>
            <MenuItem onClick={() => nav("/caixa")} active={(active == "home") ? true : false}><GoHome size={30} color="#fff" /></MenuItem>
            <MenuItem onClick={() => nav("/caixa/perfil")} active={(active == "profile") ? true : false}><FiUser size={30} color="#fff" /></MenuItem>
            <MenuItem onClick={() => nav("/caixa/vendas/lista")} active={(active == "sellList") ? true : false}><FiShoppingCart size={30} color="#fff" /></MenuItem>
            <MenuItem onClick={() => nav("/caixa/vendas")} active={(active == "sell") ? true : false}><LiaCartPlusSolid size={30} color="#fff" /></MenuItem>
            <MenuItem onClick={() => nav("/caixa/gerenciar/produtos")} active={(active == "products") ? true : false}><AiFillProduct size={30} color="#fff" /></MenuItem>
            {role == "admin" && (
                <>
                    <MenuItem onClick={() => nav("/caixa/gerenciar/categorias")} active={(active == "tag") ? true : false}><FaTag size={30} color="#fff" /></MenuItem>
                    <MenuItem onClick={() => nav("/caixa/gerenciar/funcionarios")} active={(active == "func") ? true : false}><FaUserPlus size={30} color="#fff" /></MenuItem>
                </>
            )
            }
            <LogoutButton onClick={logOff}><CiLogout size={30} color="#fff" /></LogoutButton>
        </Container>
    )
}