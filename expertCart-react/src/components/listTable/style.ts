import styled from "styled-components";

export const Table = styled.table`
    width: 100%;
    align-self: baseline;

    td, th{
        height: 60px;
        text-align: center;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
    }

    .btnDel{
        padding: 10px 15px;
        border: 0;
        background-color: #F59797;
        color: #fff;
        border-radius: 10px;
        cursor: pointer;
    }
`;
