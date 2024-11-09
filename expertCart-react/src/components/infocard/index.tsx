import { MdAttachMoney } from "react-icons/md"
import { Container } from "./style"
import { formatCurrency } from "../../utils/functions";

interface InfoCardProps {
    value: string;
}

export const InfoCard = ({value}:InfoCardProps) => {
    return (
        <Container>
            <div className="icon">
                <MdAttachMoney size={25} />
            </div>
            <div className="info">
                <p>Vendas realizadas</p>
                <h2>{formatCurrency(value)}</h2>
            </div>
        </Container>
    )
}