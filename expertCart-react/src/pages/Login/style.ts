import styled from "styled-components";

export const Container = styled.div`
    position: fixed;
    width: 100%;
    height: 100%;
    display: flex;
`;

export const Cover = styled.div`
    width: 50%;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    h1{
        font-size: 27px;
        margin:40px 0 15px;
    }

    p{
        opacity: 0.6;
    }
`;

export const LoginForm = styled.div`
    width: 50%;
    padding: 25px;
    background-color: #f4f7ff;
    display: flex;
    flex-direction: column;
    align-items: center;

    h1{
        font-size: 27px;
        margin:40px 0 15px;
    }

    p{
        opacity: 0.6;
        margin-bottom: 50px;
    }
`;

export const InputCode = styled.div`
    width: 80%;
    background-color: #ffffff;
    padding: 35px 25px;
    border-radius: 15px;
    box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.05);

    p{
        font-size: 14px;
        opacity: 0.6;
        margin-bottom: 10px;
    }

    .inputList{
        display: flex;
        column-gap: 5px;

        input{
            font-size: 22px;
            text-align: center;
            width: 40px;
            height: 40px;
            border-radius: 5px;
            background-color: #F4F7FF;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
    }
`;

export const Button = styled.button`
    width: 80%;
    height: 50px;
    margin-top: 25px;
    border-radius: 10px;
    background: #D7E2FF;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    cursor: pointer;
    font-size: 20px;
    border: 0;
    text-shadow: 
        -1px -1px 0 rgba(0, 0, 0, 0.23),  
        1px -1px 0 rgba(0, 0, 0, 0.23),   
        -1px 1px 0 rgba(0, 0, 0, 0.23),   
        1px 1px 0 rgba(0, 0, 0, 0.23);

    &:disabled{
        cursor: initial;
        background: #ccc;
    }
`;
