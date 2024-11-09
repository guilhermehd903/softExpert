import styled from "styled-components";

export const Container = styled.div`
    width: auto;
    background-color: #fff;
    box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.05);
    padding-top: 15px;

    h1{
        color: #A6BEFF;
        border-left: 6px solid #A6BEFF;
        font-size: 22px;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
    }

    table{
        width: 100%;
        padding: 0 25px;
        td, th{
            text-align: center;
            height: 50px;
        }
    }
`;