import { Header } from "./style"

interface HeaderListProps{
    title?: string;
    desc?: string;
}

export const HeaderList = ({title, desc}:HeaderListProps) => {
    return (
        <Header>
            <h1>{title}</h1>
            <small>{desc}</small>
        </Header>
    )
}