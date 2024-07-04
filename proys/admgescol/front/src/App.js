import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Header from './components/Header';
import Sidebar from './components/Sidebar';
import Panel from './components/Panel';
import EmpresaList from './components/EmpresaList';
import Login from './components/Login';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import API_BASE_URL from './components/apiConstants';
import DashTrab from './components/DashTrab'; // Ajusta la ruta según tu estructura de carpetas
import Breadcrumbs from './components/Breadcrumbs'; // Importa el componente de Breadcrumb

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
  const [showDashTrab, setShowDashTrab] = useState(true);

  const handleOptionChange = (option) => {
    setCurrentOption(option);
    setShowDashTrab(false); // Oculta DashTrab cuando se selecciona una opción
  };

  const handleHomeClick = () => {
    setShowDashTrab(true);
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
    localStorage.removeItem('roleSession');
    localStorage.removeItem('userDNI');
    localStorage.removeItem('photoWorker');
    localStorage.removeItem('cargo');
    localStorage.removeItem('nombre');
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
      localStorage.setItem('userDNI', response.data.userDNI);
      localStorage.setItem('photoWorker', (response.data.foto));
      localStorage.setItem('cargo', response.data.cargo);
      localStorage.setItem('nombre', response.data.nombre);
      
    } catch (error) {
      setError('Usuario o contraseña incorrectos');
    }
    setLoading(false);
  };

  const handleSelectChange = (empresaId) => {
    setIsEmpresas(true);
    setEmpresaId(empresaId);
    console.log(isEmpresas);
  };

  useEffect(() => {
    console.log(localStorage.getItem('userDNI'))
    if (localStorage.getItem('userDNI')) {
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

  const [sidebarVisible, setSidebarVisible] = useState(false);

  const toggleSidebar = () => {
    setSidebarVisible(!sidebarVisible);
  };

  const roleSession = localStorage.getItem('roleSession');

  return (
    <div>
      {loggedIn ? (
        (isEmpresas || roleSession === '1') ? (
          <div className="container-fluid">
            <div className="row">
              <div className="col-md-12">
                <Header onLogout={handleLogout} />
              </div>
              {/* Botón para mostrar/ocultar la barra lateral en pantallas pequeñas */}
              <button
                className={`btn d-block d-sm-none ${sidebarVisible ? 'active' : ''}`}
                onClick={toggleSidebar}
                style={{ backgroundColor: '#333', color: '#fff' }}
              >
                Menú
              </button>
              {/* Oculta la barra lateral en pantallas extra pequeñas (xs) */}
              <div className={`col-md-2 ${sidebarVisible ? 'd-block' : 'd-none'} d-sm-block`}>
                <Sidebar onOptionChange={handleOptionChange} handleLogout={handleLogout} />
              </div>
              <div className="col-md-10">
                {roleSession === '3' && showDashTrab && <DashTrab onOptionChange={handleOptionChange} />}
                {!showDashTrab && (
                  <>
                    <Breadcrumbs currentOption={currentOption} onHomeClick={handleHomeClick} />
                    <Panel currentOption={currentOption} userDNI={userDNI} empresaId={empresaId} onOptionChange={handleOptionChange} />
                  </>
                )}
              </div>
            </div>
          </div>
        ) : (
          <div className="container mt-5">
            <div className="row justify-content-center">
              <div className="col-md-6">
                <div className="card">
                  <div className="card-body">
                    <h2 className="card-title text-center mb-4">Seleccione una empresa</h2>
                    <div className="mb-3">
                      <label htmlFor="empresaSelect" className="form-label">Empresa</label>
                      <select
                        id="empresaSelect"
                        className="form-select"
                        value={empresaId}
                        onChange={(e) => handleSelectChange(e.target.value)}
                      >
                        <option value="">Seleccionar empresa</option>
                        {empresas.map(empresa => (
                          <option key={empresa.id} value={empresa.id}>{empresa.RazonSocial}</option>
                        ))}
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
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
  );
};
  

export default App;