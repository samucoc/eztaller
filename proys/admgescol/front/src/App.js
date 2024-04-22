import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { BrowserRouter as Router } from 'react-router-dom';
import Header from './components/Header';
import Sidebar from './components/Sidebar';
import Panel from './components/Panel';
import EmpresaList from './components/EmpresaList';
import Login from './components/Login';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import API_BASE_URL from './components/apiConstants';

const App = () => {
  const [loggedIn, setLoggedIn] = useState(false);
  const [isEmpresas, setIsEmpresas] = useState(false);
  const [userDNI, setUserDNI] = useState('');
  const [empresaId, setEmpresaId] = useState('');
  const [empresas, setEmpresas] = useState([]);
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [currentOption, setCurrentOption] = useState('');

  const handleOptionChange = (option) => {
    setCurrentOption(option);
  };

  useEffect(() => {
    const userSession = JSON.parse(localStorage.getItem('userSession'));
    if (userSession) {
      setLoggedIn(true);
      setUserDNI(userSession);
    }
  }, []);

  const handleLogout = () => {
    localStorage.removeItem('userSession');
    setLoggedIn(false);
    setUserDNI('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      const response = await axios.post(`${API_BASE_URL}/users/sign-in`, { userEmail: username, userPassword: password });
      setUserDNI(response.data.userDNI);
      setLoggedIn(true);
      localStorage.setItem('userSession', response.data.userDNI);
      localStorage.setItem('roleSession', response.data.role_id);
    } catch (error) {
      setError('Usuario o contraseña incorrectos');
    }
    setLoading(false);
  };

  const handleSelectChange = (empresaId) => {
    setIsEmpresas(true);
    setEmpresaId(empresaId);
  };

  useEffect(() => {
    if (userDNI) {
      axios.get(`${API_BASE_URL}/empresas/trabajadores/${userDNI}`)
        .then(response => {
          setEmpresas(response.data);
        })
        .catch(error => {
          console.error('Error al obtener la lista de empresas:', error);
          setError('Error al obtener la lista de empresas');
        });
    }
  }, [userDNI]);

  return (
    <div className="app">
      <div className="content">
        {loggedIn ? (
          isEmpresas || localStorage.getItem('roleSession') === '1' || localStorage.getItem('roleSession') === '2' ? (
            <div className="container-fluid">
              <div className="row">
                <div className="col-md-12">
                  <Header onLogout={handleLogout} />
                </div>
                <div className="col-md-3">
                  <Sidebar onOptionChange={handleOptionChange} />
                </div>
                <div className="col-md-9">
                  <Panel currentOption={currentOption} userDNI={userDNI} />
                </div>
              </div>
            </div>
          ) : (
            <EmpresaList
              empresaId={empresaId}
              empresas={empresas}
              handleSelectChange={handleSelectChange}
            />
          )
        ) : (
          <Login
            username={username}
            password={password}
            loading={loading}
            error={error}
            setUsername={setUsername}
            setPassword={setPassword}
            handleSubmit={handleSubmit}
          />
        )}
      </div>
    </div>
  );
  
}

export default App;