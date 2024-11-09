import { Dispatch, SetStateAction } from "react";
import { Container } from "./style"

interface InputProps {
    label?: string;
    set: Dispatch<SetStateAction<any>>;
}

export const File = ({ label, set }: InputProps) => {

    return (
        <Container>
            <label>{label}</label>
            <input type="file" onChange={(e) => set(e.target.files)} />
            <small>*Somente PNG</small>
        </Container>
    )
}