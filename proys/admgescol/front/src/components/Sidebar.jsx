import React, { useState, useEffect } from 'react';
import '../css/Sidebar.css';

const Sidebar = ({ onOptionChange, handleLogout }) => {
  const [adminMenuOpen, setAdminMenuOpen] = useState(false);
  const [adminGescolMenuOpen, setAdminGescolMenuOpen] = useState(false);
  const [workerMenuOpen, setWorkerMenuOpen] = useState(false);
  const [role, setRole] = useState(null); // Estado para almacenar el role_id
  const [photoWorker, setphotoWorker] = useState(null); // Estado para almacenar el role_id
  const [nombre, setnombre] = useState(null); // Estado para almacenar el role_id
  const [cargo, setcargo] = useState(null); // Estado para almacenar el role_id

  useEffect(() => {
    const roleSession = localStorage.getItem('roleSession');
    const photoWorker = localStorage.getItem('photoWorker');
    const nombre = localStorage.getItem('nombre');
    const cargo = localStorage.getItem('cargo');
    if (roleSession) {
      setRole(JSON.parse(roleSession));
    }
    if (photoWorker) {
      setphotoWorker(photoWorker); // No JSON.parse for strings
    }
    if (nombre) {
      setnombre(nombre); // No JSON.parse for strings
    }
    if (cargo) {
      setcargo(cargo); // No JSON.parse for strings
    }
  }, []);

  const toggleAdminMenu = () => {
    setAdminMenuOpen(!adminMenuOpen);
    setWorkerMenuOpen(false);
    setAdminGescolMenuOpen(false);
  };

  // const toggleWorkerMenu = () => {
  //   setWorkerMenuOpen(!workerMenuOpen);
  //   setAdminMenuOpen(false);
  //   setAdminGescolMenuOpen(false);
  // };

  const toggleAdminGescolMenu = () => {
    setAdminGescolMenuOpen(!adminGescolMenuOpen);
    setAdminMenuOpen(false);
    setWorkerMenuOpen(false);
  };

  const defaultPhoto = 'https://www.gravatar.com/avatar/?d=mp';
  
  return (
    <div className="sidebar" style={{ height: '100% !important' }}>
      <ul>
        {role === 1 && (
          <>
            <li onClick={toggleAdminGescolMenu}>
            Administración GESCOL
              <ul>
                <li onClick={() => onOptionChange('LiquidacionesToPdf')}>
                  Obtener Liquidaciones de Archivo PDF
                </li>
              </ul>
          </li>
          <li onClick={toggleAdminGescolMenu}>
            Mantenedores GESCOL
              <ul>
                <li onClick={() => onOptionChange('Empresas')}>
                  Empresas
                </li>
                <li onClick={() => onOptionChange('Users')}>
                  Usuarios
                </li>
                <li onClick={() => onOptionChange('Roles')}>
                  Roles
                </li>
                <li onClick={() => onOptionChange('Trabajadores')}>
                  Trabajadores
                </li>
                <li onClick={() => onOptionChange('Comunas')}>
                  Comunas
                </li>
                <li onClick={() => onOptionChange('Cargos')}>
                  Cargos
                </li>
                <li onClick={() => onOptionChange('Sexo')}>
                  Sexo
                </li>
                <li onClick={() => onOptionChange('Tipo_Docs')}>
                  Tipo de Documentos
                </li>
              </ul>
          </li>
        </>
        )}
        {role === 2 && (
          <li onClick={toggleAdminMenu}>
            Administración
              <ul>
                <li onClick={() => onOptionChange('Dashboard')}>
                  Documentos
                </li>
                <li onClick={() => onOptionChange('Trabajadores')}>
                  Trabajadores
                </li>
              </ul>
          </li>
        )}
        {role === 3 && (
          <div>
            <div className="worker-info">
              <img  src={photoWorker !== "null" ? photoWorker : defaultPhoto} 
                    alt="Foto del Trabajador" 
                    className="worker-photo" />
              <div className="worker-details">
                <h2>{nombre}</h2>
                <p>{cargo}</p>
              </div>
              <a onClick={() => onOptionChange('Resumen')} className="btn btn-outline-light text-center">
                <div className="icon-text">
                  <span>Ficha</span>
                </div>
              </a>
            </div>
          </div>
        )}
      </ul>
    </div>
  );
};

export default Sidebar;
