import styled from "styled-components";

interface ContainerProps{
    isOpen?: boolean;
}

export const Container = styled.div<ContainerProps>`
    width: 100%;
    height: 100%;
    z-index: 300;
    position: fixed;
    display: ${(props) => (props.isOpen) ? "flex" : "none"};
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.4);
`;

export const ModalBody = styled.div`
    width: 400px;
    height: 400px;
    background-color: #fff;
    box-shadow: 0 4px 4px 0 rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    flex-direction: column;

    header{
        padding: 35px 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .body{
        padding: 15px;
    }

    .footer{
        height: 80px;
        margin-top: auto;
        border-top: 1px solid rgba(0,0,0,0.1);
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;

        button{
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 10px;
            border: 0;
            background-color: transparent;

            &.btnCancel{
                box-shadow: 0 4px 4px 0 rgba(0,0,0,0.1);
            }

            &.confirm{
                background-color: #8AAAFF;
                color: #fff;
            }
        }
    }
`;