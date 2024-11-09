import styled from "styled-components";

export const Form = styled.form`
    padding: 25px;
    display: flex;
    flex-direction: column;
    row-gap: 10px;
    width: 100%;
    border-left: 1px solid rgba(0, 0, 0, 0.1);

    h1{
        font-size: 18px;
    }

    button{
        width: 100%;
        height: 45px;
        border-radius: 25px;
        border: 0;
        color: #fff;
        background-color: #A6BEFF;
        font-size: 16px;
        font-weight: bold;
        margin-top: 20px;
        cursor: pointer;

        &:disabled{
            opacity: 0.6;
        }
    }
`;
