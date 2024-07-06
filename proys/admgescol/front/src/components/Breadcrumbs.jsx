import React from 'react';

const Breadcrumbs = ({ currentOption, onHomeClick }) => {
  const breadcrumbMap = {
    'Resumen': 'Datos Personales',
    'Dashboard': 'Documentos',
    'ListadoReglamento': 'Documentos Laborales',
    'ListadoContratos': 'Liquidaciones',
    'Documentos': 'Solicitudes',
    'ComunicaEmplea': 'Comunicación Empleador',
    // Agrega más mappings según sea necesario
  };

  return (
    <nav aria-label="breadcrumb">
      <ol className="breadcrumb">
        <li className="breadcrumb-item">
          <a href="#" onClick={onHomeClick}>Home</a>
        </li>
        {currentOption && <li className="breadcrumb-item active" aria-current="page">{breadcrumbMap[currentOption] || currentOption}</li>}
      </ol>
    </nav>
  );
};

export default Breadcrumbs;

