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

    header{
        height: 200px;
    }

    .profile-control{
        display: flex;
        flex-direction: column;
        height: 300px;
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .edit-user{
        padding: 50px;
        background-color: #fff;
        min-height: calc(100% - 500px);
        display: grid;
        grid-template-columns: 40% 60%;
        margin: auto;
        justify-content: space-evenly;

        h2{
            margin-bottom: 5px;
        }
        p{
            opacity: 0.6;
            font-size: 15px;
        }
    }
`;

export const ProfilePhoto = styled.div`
    width: 90%;
    margin: auto;
    transform: translateY(-25%);
    display: flex;
    flex-direction: column;

    .top{
        column-gap: 30px;
        display: flex;
        align-items: center;

        img{
            width: 200px;
            height: 200px;
            border-radius: 200px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            background-color: #ccc;
            border: 3px solid #fff;
        }

        button{
            padding: 15px 25px;
            background-color: transparent;
            border: 1px solid rgba(0, 0, 0, 0.1);
            margin-left: auto;
        }

        .info{
            h2{
                margin-bottom: 5px;
            }
            p{
                opacity: 0.7;
                font-size: 15px;
            }
        }

    }

    .btnSave{
        padding: 15px 25px;
        background-color: #A6BEFF;
        border: 0;
        margin-left: auto;
        color: #fff;
        transform: translateY(50px);

        &:disabled{
            opacity: 0.5;
        }
    }
`;
