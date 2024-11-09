import styled from "styled-components";


export const Container = styled.div`
    position: fixed;
    z-index: 2;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    animation: loading 2s infinite alternate;

    p{
        font-size: 22px;
        margin-bottom: 5px;
    }

    @keyframes loading {
        from{
            color: #fff;
            background-color: #A6BEFF;
        }
        to{
            color: #A6BEFF;
            background-color: #fff;
        }
    }
`;