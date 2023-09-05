import React from 'react';
import { Link } from 'react-router-dom';
import './despachos.css';
import logo from '../assets/logo0.png';  // Asegúrate de ajustar la ruta según donde tengas tu imagen

const Menu = () => {
  return (
      <div className="navbar navbar-expand-lg navbar-light bg-light" style="background-color: rgb(36, 37, 38) !important; color: rgb(235, 165, 28); display: flex; justify-content: center; align-items: center; font-size: 20px;">
        <a className="navbar-brand" href="/">               
          <img src={logo} alt="MiApp Logo" width="48" height="48" className="d-inline-block align-top" />
        </a>
        <div className="collapse navbar-collapse" id="navbarNav">
          <ul className="navbar-nav ml-auto">
            <li className="nav-item">
              <Link className="nav-link" to="/clientes">Clientes</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/despachos">Despachos</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/conductores">Conductores</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/vehiculos">Vehiculos</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/configuracion">Configuración</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/perfil">Perfil</Link>
            </li>
          </ul>
        </div>
      </div>
  );
};

export default Menu;