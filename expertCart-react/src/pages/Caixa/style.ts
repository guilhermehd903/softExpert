import styled from "styled-components";

export const Main = styled.div`
    background: #F4F7FF;
    position: fixed;
    width: calc(100% - 100px);
    margin-left: 100px;
    height: 100%;
    padding: 50px;
    overflow-y: auto;

    h1{
        margin-bottom: 10px;
    }

    .info-card-list{
        display: grid;
        grid-template-columns: 200px 200px 200px;
        column-gap: 10px;
    }
`;