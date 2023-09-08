import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import { BrowserRouter as Router, Route, Routes, Redirect, Switch } from 'react-router-dom';
import {Navigate} from 'react-router-dom';

import Clientes from './components/Clientes';
import Despachos from './components/Despachos';
import Conductores from './components/Conductores';
import Vehiculos from './components/Vehiculos';
import Configuracion from './components/Configuracion';
import Perfil from './components/Perfil';
import Menu from './components/NavigationMenu';

function App() {
  const appStyles = {
    backgroundColor: '#242526', // Fondo negro
    color: '#EBA51C', // Texto amarillo
  };
 
  const [isLoggedIn, setIsLoggedIn] = useState(false);

  const handleLoginChange = (loggedInValue) => {
    setIsLoggedIn(loggedInValue);
  };
 
  return (
    <Router>
      <div className="App" style={appStyles}>
        <Menu />
        <Routes>
          <Route path="/clientes" element={<Clientes />} />
          <Route path="/despachos" element={<Despachos />} />
          <Route path="/conductores" element={<Conductores />} />
          <Route path="/vehiculos" element={<Vehiculos />} />
          <Route path="/configuracion" element={<Configuracion />} />
          <Route path="/perfil" element={<Perfil />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
