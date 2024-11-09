import styled from "styled-components";

export const Header = styled.header`
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    h1{
        font-size: 25px;
        margin-bottom: 5px;
    }

    small{
        opacity: 0.6;
        font-size: 16px;
    }
`;
