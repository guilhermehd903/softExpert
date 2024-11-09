import { useEffect, useState } from "react"
import { Main, ProfilePhoto } from "./style"
import { editUser, getUser } from "../../services/Usuario"
import { Input } from "../../components/input"
import { Loading } from "../../components/loading"
import { File } from "../../components/file"
import { BASE_URL } from "../../config"
import { convertImageToBase64, formatDate } from "../../utils/functions"

export const Perfil = () => {
    const [loading, setloading] = useState(false);
    const [touched, settouched] = useState<any>("");

    const [photo, setPhoto] = useState<any>("");

    const [id, setid] = useState<any>("");
    const [createdAt, setcreatedAt] = useState<any>("");

    const [nome, setnome] = useState<any>("");
    const [email, setemail] = useState<any>("");
    const [cpf, setcpf] = useState<any>("");
    const [file, setFile] = useState<any>();

    useEffect(() => {
        userInfo();
    }, []);

    const userInfo = async () => {
        setloading(true);
        const info = await getUser();

        if (info) {
            setid(info.response.data.id);
            setcreatedAt(info.response.data.created_at);
            setnome(info.response.data.nome);
            setemail(info.response.data.email);
            setcpf(info.response.data.cpf);
            setPhoto(info.response.data.profile);
            settouched(info.response.data.nome + info.response.data.email + info.response.data.cpf);
        }

        setloading(false);
    }

    const saveInfo = async () => {
        const photo = (file) ? await convertImageToBase64(file[0]) : "";

        const req = await editUser(nome, email, cpf, photo as string, id);

        if (req) {
            userInfo();
        }
    }

    const isTouched = () => {
        const photo = (file) ? "file" : "";
        return !(touched != (nome + email + cpf + photo));
    }

    return (
        <Main>
            {loading ? <Loading /> : null}
            <header></header>
            <div className="profile-control">
                <ProfilePhoto>
                    <div className="top">
                        <img src={(photo) ? BASE_URL + "/" + photo : "#"} />
                        <div className="info">
                            <h2>{nome}</h2>
                            <p>Parte da equipe desde {formatDate(createdAt)}</p>
                        </div>
                    </div>
                    <button className="btnSave" onClick={saveInfo} disabled={isTouched()}>Salvar mudanças</button>
                </ProfilePhoto>
            </div>
            <div className="edit-user">
                <div className="label">
                    <h2>Informações pessoais</h2>
                    <p>Informações particulares acessiveis ao supervisor</p>
                </div>
                <div className="form">
                    <Input label="Nome" placeholder="Informe nome" value={nome} set={setnome} /><br />
                    <Input label="Email" placeholder="Informe email" value={email} set={setemail} /><br />
                    <Input label="cpf" placeholder="Informe preço" value={cpf} set={setcpf} /><br />
                    <File set={setFile} label="Foto" />
                </div>
            </div>
        </Main>
    )
}