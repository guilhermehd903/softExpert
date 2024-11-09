import styled from "styled-components";

export const Container = styled.div`
    width: auto;
    display: flex;
    flex-direction: column;
    height: 200px;
    background-color: #fff;
    box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.05);
    padding: 15px;

    .icon{
        width: 40px;
        height: 40px;
        border-radius: 40px;
        background-color: #F4F7FF;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .info{
        margin-top: auto;

        p{
            font-size: 15px;
            opacity: 0.6;
            margin-bottom: 5px;
        }
    }
`;