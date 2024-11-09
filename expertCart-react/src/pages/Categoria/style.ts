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

    .profile-control{
        display: flex;
        flex-direction: column;
        height: 300px;
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .workspace{
        background-color: #fff;
        min-height: 100%;
        display: grid;
        grid-template-columns: 70% auto;
        margin: auto;
    }
`;
