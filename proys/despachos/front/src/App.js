import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import { BrowserRouter as Router, Route, Routes, Link } from 'react-router-dom';

import Clientes from './components/Clientes';
import Despachos from './components/Despachos';
import Conductores from './components/Conductores';
import Vehiculos from './components/Vehiculos';
import Configuracion from './components/Configuracion';
import Perfil from './components/Perfil';
import Menu from './components/NavigationMenu';
import Login from './components/Login';

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
        <Menu isLoggedIn={isLoggedIn} /> {/* Mostrar el menú solo si está autenticado */}
        <Routes>
          <Route path="/clientes" element={<Clientes />} />
          <Route path="/despachos" element={<Despachos />} />
          <Route path="/conductores" element={<Conductores />} />
          <Route path="/vehiculos" element={<Vehiculos />} />
          <Route path="/configuracion" element={<Configuracion />} />
          <Route path="/login" element={<Login onLogin={handleLoginChange} />} />
          <Route path="/perfil" element={<Perfil />} />
          {/* Agregar más rutas aquí */}
          <Route path="/" element={isLoggedIn ? <Despachos /> : <Login onLogin={handleLoginChange} />} />
        </Routes>
        {isLoggedIn && (
          <div>
            {/* Agrega enlaces a otras rutas aquí */}
            <Link to="/clientes">Clientes</Link>
            <Link to="/conductores">Conductores</Link>
            <Link to="/vehiculos">Vehículos</Link>
            <Link to="/configuracion">Configuración</Link>
            <Link to="/perfil">Perfil</Link>
          </div>
        )}
      </div>
    </Router>
  );
}

export default App;