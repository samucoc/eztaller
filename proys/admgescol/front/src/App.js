import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useDispatch, useSelector } from 'react-redux';
import Header from './components/config/Header';
import Sidebar from './components/config/Sidebar';
import Panel from './components/config/Panel';
import EmpresaList from './components/config/EmpresaList';
import Login from './components/config/Login';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import API_BASE_URL from './components/config/apiConstants';
import Breadcrumbs from './components/config/Breadcrumbs';

import {
  setLoggedIn,
  setUserDNI,
  setEmpresaId,
  setEmpresas,
  setCurrentOption,
  setRoleSession,
  setShowDashTrab,
  setUsername,
  setPassword,
  setUserSession,
  setPhotoWorker,
  setCargo,
  setNombre,
} from './actions';

const App = () => {
  const dispatch = useDispatch();
  const {
    loggedIn,
    userDNI,
    empresaId,
    empresas,
    currentOption,
    roleSession,
    showDashTrab,
    username,
    password,
    loading,
    error,
  } = useSelector((state) => state);
  const { userSession, photoWorker, cargo, nombre } = useSelector((state) => state);

  const [sidebarVisible, setSidebarVisible] = useState(false);
  const [isMobileView, setIsMobileView] = useState(false);

  useEffect(() => {
    const handleResize = () => setIsMobileView(window.innerWidth <= 768);
    window.addEventListener('resize', handleResize);
    handleResize(); // Initialize on mount
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  useEffect(() => {
    if (loggedIn && userDNI && empresas.length === 0) {
      axios.get(`${API_BASE_URL}/empresas/trabajadores/${userDNI}`)
        .then((response) => {
          dispatch(setEmpresas(response.data));
          if (response.data.length === 1) {
            dispatch(setEmpresaId(response.data[0].id));
          }
        })
        .catch((error) => console.error('Error al obtener la lista de empresas:', error));
    }
  }, [loggedIn, userDNI, empresas.length, dispatch]);

  const handleOptionChange = (option) => {
    dispatch(setCurrentOption(option));
    dispatch(setShowDashTrab(false));
  };

  const handleLogout = () => {
    localStorage.clear();
    dispatch(setLoggedIn(false));
    dispatch(setUserDNI(''));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post(`${API_BASE_URL}/users/sign-in`, {
        userEmail: username,
        userPassword: password,
      });
      const { userDNI, role_id, foto, cargo, nombre } = response.data;
  
      // Dispatch to Redux store instead of setting in localStorage
      dispatch(setUserSession(userDNI));
      dispatch(setRoleSession(role_id));
      dispatch(setUserDNI(userDNI));
      dispatch(setPhotoWorker(foto));
      dispatch(setCargo(cargo));
      dispatch(setNombre(nombre));
  
      // Set logged in state
      dispatch(setLoggedIn(true));
    } catch (error) {
      console.error('Usuario o contraseña incorrectos');
    }
  };

  if (!loggedIn) {
    return (
      <Login
        username={username}
        password={password}
        loading={loading}
        error={error}
        setUsername={(value) => dispatch(setUsername(value))}
        setPassword={(value) => dispatch(setPassword(value))}
        handleSubmit={handleSubmit}
      />
    );
  }

  if (roleSession === "1" || empresaId) {
    return (
      <div className="container-fluid">
        <div className="row">
          <div className="col-md-12">
            <Header onLogout={handleLogout} />
          </div>
          {isMobileView && (
            <button
              className={`btn d-block d-sm-none ${sidebarVisible ? 'active' : ''}`}
              onClick={() => setSidebarVisible(!sidebarVisible)}
              style={{ backgroundColor: '#333', color: '#fff' }}
            >
              Menú
            </button>
          )}
          <div className={`${isMobileView ? (sidebarVisible ? 'd-block col-12' : 'd-none col-12') : 'col-md-2'} d-sm-block`}>
            <Sidebar handleLogout={handleLogout} selectedEmpresa={empresaId} />
          </div>
          <div className="col-md-10">
            <Breadcrumbs currentOption={currentOption} selectedEmpresa={empresaId} />
            <Panel
              currentOption={currentOption}
              userDNI={userDNI}
              empresaId={empresaId}
              setCurrentOption={handleOptionChange}
            />
          </div>
        </div>
      </div>
    );
  }

  return (
    <EmpresaList
      empresas={empresas}
      empresaId={empresaId}
      handleSelectChange={(id) => dispatch(setEmpresaId(id))}
    />
  );
};

export default App;
