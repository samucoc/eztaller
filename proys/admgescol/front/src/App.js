import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useDispatch, useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';
import Header from './components/config/Header';
import Sidebar from './components/config/Sidebar';
import Panel from './components/config/Panel';
import EmpresaList from './components/config/EmpresaList';
import Login from './components/config/Login';
import Breadcrumbs from './components/config/Breadcrumbs';
import { API_BASE_URL } from './components/config/apiConstants';
import {
  Box, Container, CssBaseline, IconButton, Drawer, useMediaQuery, Button, Grid
} from '@mui/material';
import MenuIcon from '@mui/icons-material/Menu';
import { green } from '@mui/material/colors';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import './App.css'; // Import the new CSS file

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
  setToken,
} from './actions';

const App = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const {
    loggedIn,
    userDNI,
    empresaId,
    empresas,
    currentOption,
    roleSession,
    username,
    password,
    loading,
    error,
    token,
  } = useSelector((state) => state);
  const { userSession, photoWorker, cargo, nombre } = useSelector((state) => state);

  const [sidebarVisible, setSidebarVisible] = useState(false);
  const isMobileView = useMediaQuery('(max-width:768px)');

  const checkTokenValidity = async (dispatch, navigate) => {
    try {
      await axios.post(`${API_BASE_URL}/token/check-token`, {token});
    } catch (error) {
      // Token is invalid or request failed
      console.error('Token invalid or check-token request failed:', error);
      // Handle logout if token is invalid
      localStorage.clear();
      dispatch(setLoggedIn(false));
      dispatch(setUserDNI(''));
      dispatch(setEmpresaId(''));
      dispatch(setUserSession(''));
      dispatch(setRoleSession(''));
      dispatch(setPhotoWorker(''));
      dispatch(setCargo(''));
      dispatch(setNombre(''));
      dispatch(setToken(''));

      navigate('/login'); // Redirect to login page or wherever appropriate
    }
  };

  const theme = createTheme({
    palette: {
      primary: {
        main: green[800], // Green tones for the primary color
      },
      text: {
        primary: '#FFFFFF', // White text for primary text
      },
    },
  });

  useEffect(() => {
    const interval = setInterval(() => {
      if (loggedIn) {
        checkTokenValidity(dispatch, navigate);
      }
    }, 10 * 1000); 

    return () => clearInterval(interval); // Clean up the interval on component unmount
  }, [loggedIn, dispatch, navigate]);

  useEffect(() => {
    axios.get(`${API_BASE_URL}/empresas/trabajadores/${userDNI}`)
      .then((response) => {
        dispatch(setEmpresas(response.data));
        if (response.data.length === 1) {
          dispatch(setEmpresaId(response.data[0].id));
          if (roleSession === "3") {
            navigate('/UserDashboard');
          }
          else {
            if (roleSession !== "1") {
              navigate('/Empresas');
            }
          }
        } else if (roleSession === "1") {
          navigate('/Empresas');
        }
      })
      .catch((error) => console.error('Error al obtener la lista de empresas:', error));
  }, [loggedIn, userDNI, empresas.length, dispatch]);

  const handleOptionChange = (option) => {
    dispatch(setCurrentOption(option));
    dispatch(setShowDashTrab(false));
  };

  const handleLogout = () => {
    localStorage.clear();
    dispatch(setLoggedIn(false));
    dispatch(setUserDNI(''));
    dispatch(setEmpresaId(''));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post(`${API_BASE_URL}/users/sign-in`, {
        userEmail: username,
        userPassword: password,
      });
      const { userDNI, role_id, foto, cargo, nombre, token } = response.data;

      dispatch(setUserSession(userDNI));
      dispatch(setRoleSession(role_id));
      dispatch(setUserDNI(userDNI));
      dispatch(setPhotoWorker(foto));
      dispatch(setCargo(cargo));
      dispatch(setNombre(nombre));
      dispatch(setToken(token));

      dispatch(setLoggedIn(true));
    } catch (error) {
      console.error('Usuario o contraseña incorrectos');
    }
  };

  const handleSelectChange = (id) => {
    dispatch(setEmpresaId(id));
    if (roleSession === "2") {
      navigate('/Empresas');
    }
  };

  if (!loggedIn) {
    return (
      <ThemeProvider theme={theme}>
        <Login
          username={username}
          password={password}
          loading={loading}
          error={error}
          setUsername={(value) => dispatch(setUsername(value))}
          setPassword={(value) => dispatch(setPassword(value))}
          handleSubmit={handleSubmit}
        />
      </ThemeProvider>
    );
  }

  if (roleSession === "1" || empresaId) {
    return (
      <ThemeProvider theme={theme}>
        <Container
          disableGutters
          maxWidth={false}
          className="container-root"
        >
          <Header onLogout={handleLogout} className="header-root" />
          {isMobileView ? (
            <>
              <IconButton
                edge="start"
                color="inherit"
                aria-label="menu"
                onClick={() => setSidebarVisible(true)}
                className="icon-button"
              >
                <MenuIcon />
              </IconButton>
              <Drawer
                anchor="left"
                open={sidebarVisible}
                onClose={() => setSidebarVisible(false)}
                className="drawer-root"
              >
                <Sidebar handleLogout={handleLogout} selectedEmpresa={empresaId} />
              </Drawer>
              <Grid item xs={12} >
                <Breadcrumbs currentOption={currentOption} selectedEmpresa={empresaId} />
                <Panel
                  currentOption={currentOption}
                  userDNI={userDNI}
                  empresaId={empresaId}
                  setCurrentOption={handleOptionChange}
                  className="panel-white-background"
                />
              </Grid>
            </>
          ) : (
            <Box className="sidebar-container">
              <Sidebar handleLogout={handleLogout} selectedEmpresa={empresaId} />
              <Box className="panel-container">
                <Breadcrumbs currentOption={currentOption} selectedEmpresa={empresaId} />
                <Panel
                  currentOption={currentOption}
                  userDNI={userDNI}
                  empresaId={empresaId}
                  setCurrentOption={handleOptionChange}
                  className="panel-white-background"
                />
              </Box>
            </Box>
          )}
        </Container>
      </ThemeProvider>
    );
  }

  return (
    <ThemeProvider theme={theme}>
      <EmpresaList
        empresas={empresas}
        empresaId={empresaId}
        handleSelectChange={handleSelectChange}
      />
    </ThemeProvider>
  );
};

export default App;
