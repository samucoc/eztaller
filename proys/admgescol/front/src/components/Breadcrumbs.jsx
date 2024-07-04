import React from 'react';

const Breadcrumbs = ({ currentOption, onHomeClick }) => {
  const breadcrumbMap = {
    'Resumen': 'Datos Personales',
    'ListadoReglamento': 'Documentos Laborales',
    'ListadoContratos': 'Liquidaciones',
    'Documentos': 'Solicitudes',
    'Trabajadores': 'Comunicación Empleador',
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

