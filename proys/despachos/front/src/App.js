import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

import Clientes from './components/Clientes';
import Despachos from './components/Despachos';
import Configuracion from './components/Configuracion';
import Perfil from './components/Perfil';
import Menu from './components/NavigationMenu';

function App() {
  return (
    <Router>
      <div className="App">
        <Menu />
        <Routes>
          <Route path="/clientes" element={<Clientes />} />
          <Route path="/despachos" element={<Despachos />} />
          <Route path="/configuracion" element={<Configuracion />} />
          <Route path="/perfil" element={<Perfil />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
