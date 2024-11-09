import styled from "styled-components";

export const Container = styled.div`
    width: auto;
    height: 50px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    display: flex;
    align-items: center;

    label{
        padding: 0 25px;
        border-right: 1px solid rgba(0, 0, 0, 0.1);
        height: 100%;
        font-size: 14px;
        opacity: 0.6;
        line-height: 50px;
    }

    input{
        width: 100%;
        border: 0;
        padding-left: 25px;
        outline: 0;
    }

    small{
        font-size: 12px;
        color: red;
        opacity: 0.4;
    }
`;