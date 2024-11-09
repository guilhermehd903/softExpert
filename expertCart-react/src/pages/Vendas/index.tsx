import { useEffect, useState } from "react"
import { Control, Main } from "./style"
import { FaChevronLeft, FaChevronRight } from "react-icons/fa"
import { FiShoppingCart } from "react-icons/fi"
import { FaCartFlatbed } from "react-icons/fa6"
import { IoIosCall } from "react-icons/io"
import { Modal } from "../../components/modal"
import { delProdFromCart, editProdFromCart, editVenda, getvendasOpen, registerProdutoToCart } from "../../services/Vendas"
import { Select } from "../../components/select"
import { getProdutos } from "../../services/Produtos"
import { Input } from "../../components/input"
import { formatCurrency } from "../../utils/functions"
import { useNavigate } from "react-router"
import { BASE_URL } from "../../config"
import { Loading } from "../../components/loading"

export const Vendas = () => {
    const payMethods = [{ id: "CREDITO", nome: "Cartão credito" }, { id: "DEBITO", nome: "Cartão debito" }, { id: "DINHEIRO", nome: "Dinheiro" }];
    const nav = useNavigate();

    const [loading, setloading] = useState(false);
    const [modal, setModal] = useState<boolean>(false);
    const [modalConfirm, setModalConfirm] = useState<boolean>(false);
    const [products, setProducts] = useState<any>();
    const [productsList, setproductsList] = useState([]);
    const [productSelected, setProductSelected] = useState<any>();
    const [productSelectedData, setProductSelectedData] = useState<any>();
    const [summary, setSummary] = useState<any>({ imposto: 0, subtotal: 0, total: 0 });

    const [id, setId] = useState<any>();

    const [productid, setProductId] = useState<any>();
    const [addQtd, setAddQtd] = useState<any>();

    const [method, setMethod] = useState<any>();
    const [cpf, setCpf] = useState<any>();

    const openCart = async () => {
        const req = await getvendasOpen();

        if (req) {
            setId(req.response.data.id);
            setProducts(req.response.data.produtos);
            setSummary(prevCode => ({ ...prevCode, "imposto": req.response.data.imposto }));
            setSummary(prevCode => ({ ...prevCode, "subtotal": req.response.data.subtotal }));
            setSummary(prevCode => ({ ...prevCode, "total": req.response.data.total }));
        }
    }

    const fetchProducts = async () => {
        setloading(true);
        const req = await getProdutos();

        if (req) {
            setproductsList(req.response.data);
        }

        setloading(false);
    }

    const addToCart = async (event: any) => {
        event.preventDefault();

        const req = await registerProdutoToCart(productid, addQtd);

        if (req) {
            setModal(false);
            setProductId("");
            setAddQtd("");

            await openCart();
        }
    }

    const finishSell = async () => {
        const req = await editVenda(cpf, method, id);

        if (req) {
            nav("/caixa/vendas/lista");
        }
    }

    const setQtd = (action: string) => {
        if (action == "plus") {
            setProductSelectedData(data => ({ ...data, qtd: data.qtd + 1 }));
        }

        if (action == "minus" && productSelectedData.qtd > 1) {
            setProductSelectedData(data => ({ ...data, qtd: data.qtd - 1 }));
        }


        setProductSelectedData(data => ({ ...data, subtotal: data.qtd * data.preco }));

    }

    const removeProdFromCart = async () => {
        const req = await delProdFromCart(productSelected);

        if (req) {
            const selected = products.filter(item => item.rowId != productSelected);
            setProducts(selected);
            setProductSelectedData(null);
            setProductSelected(null);
        }
    }

    const saveProdFromCart = async () => {
        const req = await editProdFromCart(productSelected, productSelectedData.qtd);

        if (req) {
            await openCart();
            setProductSelectedData(null);
            setProductSelected(null);
        }
    }

    useEffect(() => {
        if (productSelected) {
            const selected = products.filter(item => item.rowId == productSelected)[0];
            setProductSelectedData(selected);
        }
    }, [productSelected]);

    useEffect(() => {
        openCart();
        fetchProducts();
    }, []);

    return (
        <>
            {loading ? <Loading /> : null}
            <Modal isOpen={modal} call={addToCart}>
                <header>
                    <h3>Incluir produto</h3>
                    <p>Inclua um produto no carrinho</p>
                </header>
                <div className="body">
                    <Select list={productsList} set={setProductId} />
                    <br />
                    <Input set={setAddQtd} value={addQtd} label="Quantidade" placeholder="Informe uma quantidade" />
                </div>
            </Modal>
            <Modal isOpen={modalConfirm} call={finishSell}>
                <header>
                    <h3>Finalizar</h3>
                    <p>Complemente informações para finalizar</p>
                </header>
                <div className="body">
                    <Select list={payMethods} set={setMethod} />
                    <br />
                    <Input set={setCpf} value={cpf} label="CPF" placeholder="CPF na nota (opcional)" />
                </div>
            </Modal>
            <Main>
                {productSelectedData ? (
                    <header>
                        <div className="img">
                            <img src={BASE_URL + "/" + productSelectedData.img} width={200} />
                        </div>
                        <div className="info">
                            <div className="top">
                                <h2>{productSelectedData.nome}</h2>
                                <div>
                                    <button onClick={removeProdFromCart}>Remover</button>&nbsp;
                                    <button onClick={saveProdFromCart}>Salvar</button>
                                </div>
                            </div>
                            <div className="quantity">
                                <div className="uni">
                                    <small>Preço/uni</small>
                                    <h3>{productSelectedData.preco}</h3>
                                </div>
                                <div className="control">
                                    <div className="minus" onClick={() => setQtd("minus")}><FaChevronLeft color="#fff" /></div>
                                    <div className="display">{productSelectedData.qtd}</div>
                                    <div className="plus" onClick={() => setQtd("plus")}><FaChevronRight color="#fff" /></div>
                                </div>
                                <div className="total">
                                    <small>Preço/uni</small>
                                    <h3>{productSelectedData.subtotal}</h3>
                                    <small>+ {(productSelectedData.total - productSelectedData.subtotal).toFixed(2)}</small>
                                </div>
                            </div>
                        </div>
                    </header>
                ) : null
                }
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>QTD</th>
                            <th>Imposto</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {(products && products.length > 0) ? products.map((item: any) => (
                            <tr className={(item.rowId == productSelected) ? "active" : ""} onClick={() => setProductSelected(item.rowId)}>
                                <td>{item.nome}</td>
                                <td>{formatCurrency(item.preco)}</td>
                                <td>{item.qtd}</td>
                                <td>{formatCurrency(item.imposto)}</td>
                                <td>{formatCurrency(item.total)}</td>
                            </tr>
                        )) : null}
                    </tbody>
                </table>
            </Main>
            <Control>
                <div className="buttonList">
                    <button onClick={() => setModal(true)}>
                        <div className="icon"><FiShoppingCart color="#fff" /></div>
                        Adicionar produto
                    </button>
                    <button>
                        <div className="icon"><FaCartFlatbed color="#fff" /></div>
                        Checar catálogo
                    </button>
                    <button>
                        <div className="icon"><IoIosCall color="#fff" /></div>
                        Chamar gerente
                    </button>
                </div>
                <div className="confirm">
                    <div className="info">
                        <div className="item">
                            <span>Imposto</span>
                            <span>{formatCurrency(summary.imposto)}</span>
                        </div>
                        <div className="item">
                            <span>Subtotal</span>
                            <span>{formatCurrency(summary.subtotal)}</span>
                        </div>
                        <div className="item">
                            <span><b>Total</b></span>
                            <span><b>{formatCurrency(summary.total)}</b></span>
                        </div>
                    </div>
                    <button onClick={() => setModalConfirm(true)}>Confirmar</button>
                </div>
            </Control>
        </>
    )
}