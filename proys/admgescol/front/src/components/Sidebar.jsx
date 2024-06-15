import React, { useState, useEffect } from 'react';
import '../css/Sidebar.css';

const Sidebar = ({ onOptionChange }) => {
  const [adminMenuOpen, setAdminMenuOpen] = useState(false);
  const [adminGescolMenuOpen, setAdminGescolMenuOpen] = useState(false);
  const [workerMenuOpen, setWorkerMenuOpen] = useState(false);
  const [role, setRole] = useState(null); // Estado para almacenar el role_id

  useEffect(() => {
    const roleSession = localStorage.getItem('roleSession');
    if (roleSession) {
      setRole(JSON.parse(roleSession));
    }
  }, []);

  const toggleAdminMenu = () => {
    setAdminMenuOpen(!adminMenuOpen);
    setWorkerMenuOpen(false);
    setAdminGescolMenuOpen(false);
  };

  const toggleWorkerMenu = () => {
    setWorkerMenuOpen(!workerMenuOpen);
    setAdminMenuOpen(false);
    setAdminGescolMenuOpen(false);
  };

  const toggleAdminGescolMenu = () => {
    setAdminGescolMenuOpen(!adminGescolMenuOpen);
    setAdminMenuOpen(false);
    setWorkerMenuOpen(false);
  };

  return (
    <div className="sidebar" style={{ height: '100% !important' }}>
      <ul>
        {role === 1 && (
          <li onClick={toggleAdminGescolMenu}>
            Administración GESCOL
              <ul>
                <li onClick={() => onOptionChange('LiquidacionesToPdf')}>
                  Obtener Liquidaciones de Archivo PDF
                </li>
                <li onClick={() => onOptionChange('Empresas')}>
                  Empresas
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
          <li onClick={toggleWorkerMenu}>
            Ficha Trabajador
              <ul>
                <li onClick={() => onOptionChange('Resumen')}>Datos Personales</li>
                <li onClick={() => onOptionChange('ListadoReglamento')}>Contratos de Trabajo y Anexo</li>
                <li onClick={() => onOptionChange('ListadoContratos')}>Reglamento Interno</li>
                <li onClick={() => onOptionChange('ListadoDocumentos')}>Liquidaciones</li>
              </ul>
          </li>
        )}
      </ul>
    </div>
  );
};

export default Sidebar;
