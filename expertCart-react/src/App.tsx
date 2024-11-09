import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom';
import { Login } from './pages/Login';
import { Caixa } from './pages/Caixa';
import "./assets/css/index.css";
import { isAuthenticated } from './utils/storage';
import { Perfil } from './pages/Perfil';
import { Vendas } from './pages/Vendas';
import { Menu } from './components/menu';
import { Container } from './styleApp';
import { Categoria } from './pages/Categoria';
import { Usuarios } from './pages/Usuarios';
import { VendasLista } from './pages/VendasLista';
import { Produtos } from './pages/Produtos';
import { CPF } from './pages/CPF';

interface PrivateProps {
  children: JSX.Element;
  redirect: string;
}

const PrivateRoute = ({ children, redirect }: PrivateProps) => {
  return isAuthenticated() ? children : <Navigate to={redirect} />
}

const App = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />

        <Route path="/cpfnanota" element={<CPF />} />

        <Route path="/caixa" element={
          <PrivateRoute redirect={'/'}>
            <Container>
              <Menu active='home'/>
              <Caixa />
            </Container>
          </PrivateRoute>
        } />
        <Route path="/caixa/perfil" element={
          <PrivateRoute redirect={'/'}>
            <Container>
              <Menu active='profile'/>
              <Perfil />
            </Container>
          </PrivateRoute>
        } />
        <Route path="/caixa/vendas" element={
          <PrivateRoute redirect={'/'}>
            <Container>
              <Menu active='sell'/>
              <Vendas />
            </Container>
          </PrivateRoute>
        } />
        <Route path="/caixa/vendas/lista" element={
          <PrivateRoute redirect={'/'}>
            <Container>
              <Menu active='sellList'/>
              <VendasLista />
            </Container>
          </PrivateRoute>
        } />
        <Route path="/caixa/gerenciar/produtos" element={
          <PrivateRoute redirect={'/'}>
            <Container>
              <Menu active='products'/>
              <Produtos />
            </Container>
          </PrivateRoute>
        } />
        <Route path="/caixa/gerenciar/categorias" element={
          <PrivateRoute redirect={'/'}>
            <Container>
              <Menu active='tag'/>
              <Categoria />
            </Container>
          </PrivateRoute>
        } />
        <Route path="/caixa/gerenciar/funcionarios" element={
          <PrivateRoute redirect={'/'}>
            <Container>
              <Menu active='func'/>
              <Usuarios />
            </Container>
          </PrivateRoute>
        } />

      </Routes>
    </BrowserRouter>
  );
};

export default App
