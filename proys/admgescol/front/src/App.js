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

  const [sidebarVisible, setSidebarVisible] = useState(false);
  const [isMobileView, setIsMobileView] = useState(false);

  const handleResize = () => {
    setIsMobileView(window.innerWidth <= 768);
  };

  const handleOptionChange = (option) => {
    dispatch(setCurrentOption(option));
    dispatch(setShowDashTrab(false));
  };

  const handleHomeClick = () => {
    dispatch(setShowDashTrab(true));
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
      dispatch(setUserDNI(response.data.userDNI));
      dispatch(setLoggedIn(true));
      dispatch(setRoleSession(response.data.role_id));
      localStorage.setItem('userSession', response.data.userDNI);
      localStorage.setItem('roleSession', response.data.role_id);
      localStorage.setItem('userDNI', response.data.userDNI);
      localStorage.setItem('photoWorker', response.data.foto);
      localStorage.setItem('cargo', response.data.cargo);
      localStorage.setItem('nombre', response.data.nombre);
    } catch (error) {
      console.error('Usuario o contraseña incorrectos');
    }
  };

  const handleSelectChange = (empresaId) => {
    dispatch(setEmpresaId(empresaId));
  };

  useEffect(() => {
    window.addEventListener('resize', handleResize);
    handleResize();
    return () => {
      window.removeEventListener('resize', handleResize);
    };
  }, []);

  useEffect(() => {
    if (loggedIn && localStorage.getItem('userDNI') && empresas.length === 0) {
      axios
        .get(`${API_BASE_URL}/empresas/trabajadores/${userDNI}`)
        .then((response) => {
          dispatch(setEmpresas(response.data));
          if (response.data.length === 1) {
            handleSelectChange(response.data[0].id);
          }
        })
        .catch((error) => {
          console.error('Error al obtener la lista de empresas:', error);
        });
    }
  }, [loggedIn, userDNI, empresas.length, dispatch]);

  return (
    <div>
      {roleSession === "1" ? (
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
              <Sidebar handleLogout={handleLogout} />
            </div>
            <div className="col-md-10">
              <>
                <Breadcrumbs currentOption={currentOption} selectedEmpresa={empresaId} />
                <Panel
                  currentOption={currentOption}
                  userDNI={userDNI}
                  empresaId={empresaId}
                  setCurrentOption={handleOptionChange}
                />
              </>
            </div>
          </div>
        </div>
        ) : (
        loggedIn ? (
          roleSession === "1" || empresaId ? (
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
                  <Sidebar handleLogout={handleLogout} />
                </div>
                <div className="col-md-10">
                  <>
                    <Breadcrumbs currentOption={currentOption} selectedEmpresa={empresaId} />
                    <Panel
                      currentOption={currentOption}
                      userDNI={userDNI}
                      empresaId={empresaId}
                      setCurrentOption={handleOptionChange}
                    />
                  </>
                </div>
              </div>
            </div>
          ) : (
            <EmpresaList
              empresas={empresas}
              empresaId={empresaId}
              handleSelectChange={handleSelectChange}
            />
          )
        ) : (
          <Login
            username={username}
            password={password}
            loading={loading}
            error={error}
            setUsername={(value) => dispatch(setUsername(value))}
            setPassword={(value) => dispatch(setPassword(value))}
            handleSubmit={handleSubmit}
          />
        )
      ) }
    </div>
  );
};

export default App;
