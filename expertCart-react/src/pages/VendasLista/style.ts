import styled from "styled-components";

export const Container = styled.div`
    background: #F4F7FF;
    position: fixed;
    width: 100%;
    height: 100%;
    display: flex;
`;

export const Main = styled.div`
    background: #F4F7FF;
    position: fixed;
    width: calc(100% - 100px);
    margin-left: 100px;
    height: 100%;
    overflow-y: auto;

    .workspace{
        background-color: #fff;
        min-height: 100%;
        display: grid;
        grid-template-columns: auto;
        margin: auto;
    }
`;
