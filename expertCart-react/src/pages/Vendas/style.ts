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
    width: calc(100% - 400px);
    margin-left: 100px;
    height: 100%;
    overflow-y: auto;

    header{
        display: grid;
        grid-template-columns: 350px auto;
        height: 200px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);

        .img{
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
        }

        .info{
            height: 100%;

            .top{
                height: 60px;
                background-color: #A6BEFF;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 20px;

                h2{
                    font-size: 20px;
                }

                button{
                    padding: 8px 15px;
                    border: 0;
                    border-radius: 5px;
                    cursor: pointer;
                }
            }

            .quantity{
                height: calc(100% - 60px);
                display: grid;
                grid-template-columns: auto auto auto;
                align-items: center;
                justify-content: space-evenly;

                h3{
                    font-size: 28px;
                }

                .control{
                    display: flex;

                    div{
                        min-width: 50px;
                        height: 50px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        
                        &.minus, &.plus{
                            background-color: #A6BEFF;
                        }
                    }
                }
            }
        }
    }

    table{
        border-spacing: 0;
        width: 100%;
        tr{
            &.active{
                background-color: #A6BEFF;
            }
            td, th{
                text-align: center;
                height: 70px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }
        }
    }
`;

export const Control = styled.div`
    width: 300px;
    height: 100%;
    background-color: #fff;
    margin-left: auto;
    display: flex;
    flex-direction: column;

    .buttonList{
        padding: 30px;
        display: flex;
        flex-direction: column;
        row-gap: 10px;

        button{
            display: flex;
            align-items: center;
            padding-left: 25px;
            column-gap: 15px;
            height: 60px;
            background-color: transparent;
            border-radius: 25px;
            border: 1px solid rgba(0, 0, 0, 0.1);

            .icon{
                border-radius: 5px;
                padding: 7px;
                background-color: #8AAAFF;
            }
        }
    }

    .confirm{
        padding: 15px;
        width: 100%;
        margin-top: auto;

        button{
            width: 100%;
            height: 55px;
            border-radius: 25px;
            border: 0;
            color: #fff;
            background-color: #A6BEFF;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
        }

        .info{
            width: 100%;

            .item{
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 10px;
            }
        }
    }
`;
