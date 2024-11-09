import styled from "styled-components";

export const Container = styled.div`
    width: 100px;
    height: 100vh;
    background-color: #A6BEFF;
    padding: 35px 0;
    position: relative;
    z-index: 50;
`;

interface MenuItemProps {
    active?: boolean;
}

export const MenuItem = styled.div<MenuItemProps>`
    width: 100%;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #A6BEFF;
    border-left: ${props => (props.active) ? "6px solid #ffffff" : "6px solid transparent"};
    margin-bottom: 30px;
    cursor: pointer;

    &:last-of-type{
        margin-bottom: 0;
    }

    &:hover{
        border-left: 6px solid #ffffff;    
    }
`;

export const LogoutButton = styled.div`
    width: 100%;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #8AAAFF;
    cursor: pointer;
    position: absolute;
    bottom: 0;
`;