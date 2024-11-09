import { Dispatch, SetStateAction } from "react";
import { Container } from "./style"

interface InputProps {
    placeholder?: string;
    value?: string;
    type?: string;
    label?: string;
    set: Dispatch<SetStateAction<any>>;
}

export const Input = ({ placeholder, value, type, label, set }: InputProps) => {

    return (
        <Container>
            <label>{label}</label>
            <input type={type} placeholder={placeholder} value={value} onChange={(e) => set(e.target.value)} />
        </Container>
    )
}