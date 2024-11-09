import { Table } from "./style"

interface ListTableProps {
    children: any;
}

export const ListTable = ({children}:ListTableProps) => {
    return (
        <Table>
            {children}
        </Table>
    )
}