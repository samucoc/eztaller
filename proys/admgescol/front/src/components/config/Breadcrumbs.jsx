import React, { useEffect, useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants';
import { useSelector, useDispatch } from 'react-redux';
import { setEmpresaId } from '../../actions';

const Breadcrumbs = () => {
  const [razonSocial, setRazonSocial] = useState('');
  const [usuario, setUsuario] = useState([]);

  const navigate = useNavigate();
  const location = useLocation();
  const dispatch = useDispatch();
  let id;
  const currentOption = useSelector((state) => state.currentOption);

  const {
    loggedIn,
    userDNI,
    empresaId,
    empresas,
    roleSession,
    showDashTrab,
    username,
    password,
    loading,
    error,
  } = useSelector((state) => state);

  const breadcrumbMap = {
    '/Empresas': 'Lista de Empresas',
    '/Documentos': 'Documentos',
    '/Usuarios': 'Usuarios',
    '/Trabajadores': 'Trabajadores',
    '/Roles': 'Roles',
    '/Comunas': 'Comunas',
    '/Cargos': 'Cargos',
    '/Sexo': 'Sexo',
    '/TipoDocs': 'Tipo de Documentos',
    '/TipoSol': 'Tipo de Solicitudes',
    '/EstadoSol': 'Estados de Solicitudes',
    '/LiquidacionesToPdf': 'Liquidaciones',
    '/DocumentosToPdf': 'Documentos Individuales',
    '/DocumentosGenToPdf': 'Documentos Generales',
    '/Empresas/:id': 'Detalles de la Empresa',
    '/ContratosUser': 'Contratos y Anexos',
    '/LiquidacionesUser': 'Liquidaciones',
    '/ReglamentosUser': 'Reglamentos',
    '/OtrosUser': 'Otros',
    '/SolicitarAnticipo': 'Solicitud de Anticipo',
    '/SolicitarPrestamo': 'Solicitud de Préstamo',
    '/SolicitarPermiso': 'Solicitud de Permiso',
    '/SolicitarVacaciones': 'Solicitud de Vacaciones',
  };

  const currentPath = location.pathname;
  const breadcrumbLabel =
    breadcrumbMap[currentPath] || currentOption ;

  const parts = currentPath.split('/'); // Split the path by '/'
  id = parts[parts.length - 1]; // Get the last part which is the ID

  if(id==='Empresas') {
    id = empresaId;
  }
  
  useEffect(() => {
    if (id !== 'Empresas' && roleSession !== "3") {
      axios
        .get(`${API_BASE_URL}/empresas/show/${id}`)
        .then((response) => {
          setRazonSocial(response.data.NombreFantasia);
          navigate(`/Empresas/${id}`);
          dispatch(setEmpresaId(id));
        })
        .catch((error) => {
          console.error('Error fetching razonSocial:', error);
          setRazonSocial('');
        });
    }
  }, [id]);

  const handleHomeClick = () => {
    if (roleSession !== "3"){
      dispatch(setEmpresaId(null)); // Clear empresaId in Redux
      navigate('/Empresas');
    }
    else{
      navigate('/UserDashboard');
    }
  };

  const handleEmpresaClick = () => {
    navigate(`/Empresas/${id}`);
    dispatch(setEmpresaId(id));
  };

  const handleEmpresaClick2 = () => {
    navigate(`/Empresas/${empresaId}`);
    dispatch(setEmpresaId(empresaId));
  };

  if (empresaId && roleSession !== "3"){
    axios
        .get(`${API_BASE_URL}/empresas/show/${empresaId}`)
        .then((response) => {
          setRazonSocial(response.data.NombreFantasia);
        })
        .catch((error) => {
          console.error('Error fetching razonSocial:', error);
          setRazonSocial('');
        });

    return (
      <nav aria-label="breadcrumb">
        <ol className="breadcrumb">
          <li className="breadcrumb-item">
            <span role="button" onClick={handleHomeClick}>
              Home
            </span>
          </li>
          <li className="breadcrumb-item">
            <span role="button" onClick={handleEmpresaClick2}>
              {razonSocial}
            </span>
          </li>
          <li className="breadcrumb-item active" aria-current="page">
            {breadcrumbLabel}
          </li>
        </ol>
      </nav>
    );
  }
  else if (roleSession === "3"){
    if (!usuario){
      axios
      .get(`${API_BASE_URL}/users/showByRut/${userDNI}`)
      .then((response) => {
        setUsuario(response.data);
      })
      .catch((error) => {
        console.error('Error fetching user data:', error);
        setUsuario('');
      });
    }
    return (
      <nav aria-label="breadcrumb">
        <ol className="breadcrumb">
          <li className="breadcrumb-item">
            <span role="button" onClick={handleHomeClick}>
              Home
            </span>
          </li>
          <li className="breadcrumb-item">
              <span role="button" onClick={handleHomeClick}>
                {usuario?.trabajador?.nombres}
              </span>
          </li>
          <li className="breadcrumb-item active" aria-current="page">
            {breadcrumbLabel}
          </li>
        </ol>
      </nav>
    );
  }

};

export default Breadcrumbs;
