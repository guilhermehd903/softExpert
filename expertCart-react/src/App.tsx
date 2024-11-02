import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { Login } from './pages/Login';
import { Pao } from './pages/Pao';

const App = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/pao" element={<Pao />} />
      </Routes>
    </BrowserRouter>
  );
};

export default App
