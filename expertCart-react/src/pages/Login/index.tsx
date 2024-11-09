import { Button, Container, Cover, InputCode, LoginForm } from "./style"
import logo from "../../assets/logo.svg";
import { useState } from "react";
import { authLogin } from "../../services/Auth";
import { setItem } from "../../utils/storage";
import { useNavigate } from "react-router";

export const Login = () => {
    const nav = useNavigate();

    const [loading, setLoading] = useState(false);
    const [code, setCode] = useState({ 1: "", 2: "", 3: "", 4: "", 5: "", 6: "" });


    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { value, nextElementSibling } = e.target;
        const pattern = /^([0-9]{1})$/;

        if (!pattern.test(value)) {
            e.target.value = "";
            return;
        }

        setCode(prevCode => ({ ...prevCode, [e.target.id]: e.target.value }));

        if (value && nextElementSibling) {
            (nextElementSibling as HTMLInputElement).focus();
        }
    };

    const authUser = async () => {
        setLoading(true);
        const finalCode = Object.values(code).join('').trim();

        if (finalCode.length != 6) {
            alert("Informe um codigo valido!");
            return;
        }

        const req = await authLogin(finalCode);

        if (req.error.length > 0) {
            alert(req.error);
        }

        setLoading(false);
        setItem("role",  req.response?.data.role);
        setItem("session", req.response?.data.jwt);
        nav("/caixa");
    }

    const codePaste = (event: React.ClipboardEvent<HTMLInputElement>) => {
        event.preventDefault();
        if(!event.clipboardData) return;

        const paste = (event.clipboardData).getData("text");

        const pattern = /^([0-9]{6})$/;

        if (pattern.test(paste)) {
            const nums = paste.split("");

            nums.forEach((num:number|string, i:number) => {
                setCode(prevCode => ({ ...prevCode, [i + 1]: num }));
            })
        }
    }

    return (
        <Container>
            <Cover>
                <img src={logo} alt="logo" width="400" />
                <h1>ExperCart system</h1>
                <p>Sistema fictício voltado para demonstrar habilidades no teste técnico</p>
            </Cover>
            <LoginForm>
                <h1>Login</h1>
                <p>Utilize formulario abaixo para acessar sistema</p>
                <InputCode>
                    <p>Código acesso</p>
                    <div className="inputList">
                        <input type="text" maxLength={1} id="1" onChange={handleInputChange} onPaste={codePaste} value={code[1]}/>
                        <input type="text" maxLength={1} id="2" onChange={handleInputChange} onPaste={codePaste} value={code[2]}/>
                        <input type="text" maxLength={1} id="3" onChange={handleInputChange} onPaste={codePaste} value={code[3]}/>
                        <input type="text" maxLength={1} id="4" onChange={handleInputChange} onPaste={codePaste} value={code[4]}/>
                        <input type="text" maxLength={1} id="5" onChange={handleInputChange} onPaste={codePaste} value={code[5]}/>
                        <input type="text" maxLength={1} id="6" onChange={handleInputChange} onPaste={codePaste} value={code[6]}/>
                    </div>
                </InputCode>
                <Button onClick={authUser} disabled={loading}>Entrar</Button>
            </LoginForm>
        </Container>
    )
}