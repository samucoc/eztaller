import React, { useState, useEffect } from 'react';
import '../css/DashTrab.css'; // Si tienes estilos adicionales para DashTrab

const DashTrabLiq = ({ userDNI, onOptionChange }) => {
  const [showDashTrabRegla, setshowDashTrabRegla] = useState(true);
  const [showDashTrabContr, setshowDashTrabContr] = useState(true);

  const currentYear = new Date().getFullYear();
  const previousYear = currentYear - 1;

  return (
    <div className="menu-container d-flex justify-content-center align-items-center">
      <div className="row w-100">
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('LiqAnioActual')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/contrato.png" className="img-fluid mb-2" alt="Contrato de Trabajo"/>
              <span>Liquidaciones Año Actual {currentYear}</span>
            </div>
          </a>
        </div>
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('LiqAnioAnterior')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Reglamento Interno"/>
              <span>Liquidaciones Año Anterior {previousYear}</span>
            </div>
          </a>
        </div>
        {/* Añadir los otros enlaces si es necesario */}
      </div>
    </div>
  );
}

export default DashTrabLiq;