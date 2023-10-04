// src/components/Login.js
import React, { useState } from 'react';
import axios from 'axios'; // Importa Axios
import API_BASE_URL from './apiConstants'; // Import the API_BASE_URL constant
import { useNavigate } from 'react-router-dom';
import logo from '../assets/logo0.png';  // Asegúrate de ajustar la ruta según donde tengas tu imagen


const Login = ({ onLogin , onAdm }) => {
  const [userEmail, setuserEmail] = useState('');
  const [userPassword, setuserPassword] = useState('');
  //const [loggedIn, setLoggedIn] = useState(false);
  const navigate = useNavigate();

  const handleLogin = async () => {
    try {
      // Realiza la solicitud POST con Axios y envía las credenciales
      const response = await axios.post(API_BASE_URL + '/users/sign-in', {
        userEmail,
        userPassword
      });

      // Verifica la respuesta y redirecciona si las credenciales son válidas
      if (response.status === 200) {
        //setLoggedIn(true);
        onLogin(true); // Llama a la función onLogin con true

        if (response.data.role_id === "1"){
		onAdm(true);
		redireccionar();

	}
	else{
		onAdm(false);
		redireccionar_2();

	}
      } else {
        alert('Credenciales incorrectas');
      }
    } catch (error) {
      console.error('Error de autenticación:', error);
      alert('Error de autenticación');
    }
  };

  const redireccionar = () => {
    	navigate('/despachos');
  	};

  const redireccionar_2 = () => {
	navigate('/transportista');
	};

  //const appStyles = {
  //  width: '30%',
  //  textAlign: 'center' // Corregido: Usar camelCase
  //};

  return (
    <div className="d-flex flex-column align-items-center justify-content-center vh-100">
      <div>
        <img src={logo} alt="MiApp Logo" width="180" height="180" className="d-inline-block align-top" />
      </div>
      <h4>Iniciar Sesión</h4>
      <div className="d-flex flex-column align-items-center container">
        <div className="row">
          <div className="col-12 mb-3 ml-3">
            <input
              type="text"
              className="form-control text-center" 
              placeholder="Usuario"
              value={userEmail}
              onChange={(e) => setuserEmail(e.target.value)}
            />
          </div>
        </div>
        <div className="row">
          <div className="col-12 mb-3 ml-3">
            <input
              type="password"
              className="form-control text-center" 
              placeholder="Contraseña"
              value={userPassword}
              onChange={(e) => setuserPassword(e.target.value)}
            />
          </div>
        </div>
        <div>
          <button onClick={handleLogin} className="btn-custom">Iniciar Sesión</button>
        </div>
      </div>
    </div>
  );
};

export default Login;
