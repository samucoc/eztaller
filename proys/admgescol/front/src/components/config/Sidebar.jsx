import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import '../../css/Sidebar.css';

const Sidebar = ({ handleLogout }) => {
  const [role, setRole] = useState(null);
  const [photoWorker, setPhotoWorker] = useState(null);
  const [nombre, setNombre] = useState(null);
  const [cargo, setCargo] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    const roleSession = localStorage.getItem('roleSession');
    const photoWorker = localStorage.getItem('photoWorker');
    const nombre = localStorage.getItem('nombre');
    const cargo = localStorage.getItem('cargo');

    if (roleSession) setRole(JSON.parse(roleSession));
    if (photoWorker) setPhotoWorker(photoWorker);
    if (nombre) setNombre(nombre);
    if (cargo) setCargo(cargo);
  }, []);

  const defaultPhoto = 'https://www.gravatar.com/avatar/?d=mp';

  const handleOptionChange = (option) => {
    navigate(`/${option}`);
  };

  return (
    <div className="sidebar" style={{ height: '100% !important' }}>
      <ul>
        {role === 1 && (
          <>
            <h3>Funcionalidades</h3>
            <ul>
              <li onClick={() => handleOptionChange('Empresas')}>Lista de Empresas</li>
              <li onClick={() => handleOptionChange('Documentos')}>Documentos</li>
              <li onClick={() => handleOptionChange('Trabajadores')}>Trabajadores</li>
              <li onClick={() => handleOptionChange('Usuarios')}>Usuarios</li>
            </ul>
            <h3>Mantenedores</h3>
            <ul>
              <li onClick={() => handleOptionChange('Roles')}>Roles</li>
              <li onClick={() => handleOptionChange('Comunas')}>Comunas</li>
              <li onClick={() => handleOptionChange('Cargos')}>Cargos</li>
              <li onClick={() => handleOptionChange('Sexo')}>Sexo</li>
              <li onClick={() => handleOptionChange('TipoDocs')}>Tipo de Documentos</li>
            </ul>
          </>
        )}
        {(role === 2 || role === 3) && (
          <div className="worker-info">
            <img src={photoWorker !== "null" ? photoWorker : defaultPhoto} alt="Foto del Trabajador" className="worker-photo" />
            <div className="worker-details">
              <h2>{nombre}</h2>
              <p>{cargo}</p>
            </div>
            <a onClick={() => handleOptionChange('Resumen')} className="btn btn-outline-light text-center">
              <div className="icon-text">
                <span>Ficha</span>
              </div>
            </a>
          </div>
        )}
      </ul>
    </div>
  );
};

export default Sidebar;
