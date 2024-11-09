import { Container } from "./style"

interface InputProps {
    list: any;
    set: (e) => any;
}

export const Select = ({ list,set }: InputProps) => {

    return (
        <Container>
            <select name="" id="" onChange={(e) => set(e.target.value)}>
                <option value="">Selecione uma opção</option>
                {(list && list.length > 0) ? list.map((item: any) => (
                    <option value={item.id}>{item.nome}</option>
                )) : null}
            </select>
        </Container>
    )
}