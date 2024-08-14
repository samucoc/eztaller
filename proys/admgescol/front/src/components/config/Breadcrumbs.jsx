import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Breadcrumbs = ({ currentOption, onHomeClick, selectedEmpresa }) => {
  
  const [razonSocial, setRazonSocial] = useState('');

  const breadcrumbMap = {
    'Resumen': 'Datos Personales',
    'Dashboard': 'Documentos',
    'ListadoReglamento': 'Documentos Laborales',
    'ListadoContratos': 'Liquidaciones',
    'Documentos': 'Solicitudes',
    'ComunicaEmplea': 'Comunicación Empleador',
    'Empresas': 'Lista de Empresas',
    'Trabajadores': 'Trabajadores',
    'Roles': 'Roles',
    'Comunas': 'Comunas',
    'Cargos': 'Cargos',
    'Sexo': 'Sexo',
    'Tipo_Docs': 'Tipo de Documentos',
    'Users': 'Usuarios',
  };

  useEffect(() => {
    if (selectedEmpresa) {
      // Asumiendo que el endpoint es algo como `/api/empresas/{id}`
      axios.get(`/api/empresas/${selectedEmpresa}`)
        .then(response => {
          const { razonSocial } = response.data;
          setRazonSocial(razonSocial);
        })
        .catch(error => {
          console.error("Error fetching razonSocial:", error);
          setRazonSocial(''); // Reinicia el estado si hay un error
        });
    }
  }, [selectedEmpresa]);

  return (
    <nav aria-label="breadcrumb">
      <ol className="breadcrumb">
        <li className="breadcrumb-item">
          <a href="#" onClick={onHomeClick}>Home</a>
        </li>
        {selectedEmpresa && (
          <li className="breadcrumb-item active" aria-current="page">
            {breadcrumbMap[currentOption] || currentOption}
          </li>
        )}
        {selectedEmpresa && (
          <li className="breadcrumb-item active" aria-current="page">
            {razonSocial}
          </li>
        )}
        {!selectedEmpresa && currentOption && (
          <li className="breadcrumb-item active" aria-current="page">
            {breadcrumbMap[currentOption] || currentOption}
          </li>
        )}
      </ol>
    </nav>
  );
};

export default Breadcrumbs;
