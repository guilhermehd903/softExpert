import { Container, ModalBody } from "./style"

interface ModalProps{
    isOpen?: boolean;
    children: any;
    call: any;
}

export const Modal = ({isOpen, children, call}:ModalProps) =>{
    return (
        <Container isOpen={isOpen}>
            <ModalBody>
                {children}
                <div className="footer">
                    <button className="btnCancel">Cancelar</button>
                    <button className="confirm" onClick={call}>Confirmar</button>
                </div>
            </ModalBody>
        </Container>
    )
}