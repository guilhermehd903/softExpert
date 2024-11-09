import { Form } from "./style"

interface ListFormProps{
    children: any;
    title?: string;
    call: (e:any) => Promise<void>;
    loading?: boolean;
}

export const ListForm = ({children, title, call, loading}:ListFormProps) => {
    return (
        <Form>
            <h1>{title}</h1>
            <br />
            {children}
            <button onClick={call} disabled={loading}>Cadastrar</button>
        </Form>
    )
}