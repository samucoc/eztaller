import React, { useState, useEffect } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import { BrowserRouter as Router, Route, Routes, Navigate } from 'react-router-dom';

import Clientes from './components/Clientes';
import Despachos from './components/Despachos';
import Conductores from './components/Conductores';
import Vehiculos from './components/Vehiculos';
import Configuracion from './components/Configuracion';
import Perfil from './components/Perfil';
import Menu from './components/NavigationMenu';
import Login from './components/Login';
import Transportista from './components/Transportista';

function App() {
  const appStyles = {
    backgroundColor: '#242526', // Fondo negro
    color: '#EBA51C', // Texto amarillo
  };

  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [isUserAdm, setIsUserAdm] = useState(false);

  // Verificar si el usuario está autenticado al cargar la página
  useEffect(() => {
    const userLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    setIsLoggedIn(userLoggedIn);
    const userAdm = localStorage.getItem('isUserAdm') === 'true';
    setIsUserAdm(userAdm);
  }, []);


const handleLoginChange = (loggedInValue) => {
  setIsLoggedIn(loggedInValue);
  // Almacenar el estado de inicio de sesión en el almacenamiento local para mantener la sesión
  localStorage.setItem('isLoggedIn', loggedInValue);
};

const handleAdmChange = (isUserAdmValue) => {
  setIsUserAdm(isUserAdmValue); // Usar setIsUserAdm para actualizar el estado
  localStorage.setItem('isUserAdm', isUserAdmValue);
};

  return (
    <Router>
      <div className="App" style={appStyles}>
	{localStorage.getItem('isLoggedIn') === 'true' && localStorage.getItem('isUserAdm') === 'true' ? <Menu /> : '' }
        <Routes>
          <Route path="/despachos" element={localStorage.getItem('isLoggedIn') ? <Despachos /> : <Navigate to="/login" />} />
          <Route path="/clientes" element={localStorage.getItem('isLoggedIn') ? <Clientes /> : <Navigate to="/login" />} />
          <Route path="/conductores" element={localStorage.getItem('isLoggedIn') ? <Conductores /> : <Navigate to="/login" />} />
          <Route path="/vehiculos" element={localStorage.getItem('isLoggedIn') ? <Vehiculos /> : <Navigate to="/login" />} />
          <Route path="/configuracion" element={localStorage.getItem('isLoggedIn') ? <Configuracion /> : <Navigate to="/login" />} />
          <Route path="/login" element={<Login onLogin={handleLoginChange} onAdm={handleAdmChange} />} />
          <Route path="/perfil" element={localStorage.getItem('isLoggedIn') ? <Perfil /> : <Navigate to="/login" />} />
  	  <Route path="/transportista" element={localStorage.getItem('isLoggedIn') ? <Transportista /> : <Navigate to="/login" />} />
          {/* Ruta de inicio */}
          <Route path="/" element={localStorage.getItem('isLoggedIn') ? <Despachos /> : <Navigate to="/login" />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
