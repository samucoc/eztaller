import React, { useState, useEffect } from 'react';
import '../../css/DashTrab.css'; // Si tienes estilos adicionales para DashTrab

const DashTrabDocLabRegla = ({ userDNI, onOptionChange }) => {
  const [showDashTrabRegla, setshowDashTrabRegla] = useState(true);
  const [showDashTrabContr, setshowDashTrabContr] = useState(true);

  const currentYear = new Date().getFullYear();
  const previousYear = currentYear - 1;

  return (
    <div className="menu-container d-flex justify-content-center align-items-center">
      <div className="row w-100">
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('DashTrabDocLabReglaRIOHS')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/contrato.png" className="img-fluid mb-2" alt="RIOHS"/>
              <span>RIOHS</span>
            </div>
          </a>
        </div>
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('DashTrabDocLabReglaFunGen')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Funciones Generales"/>
              <span>Funciones Generales</span>
            </div>
          </a>
        </div>        
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('DashTrabDocLabReglaCarga')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Carga Horaria"/>
              <span>Carga Horaria</span>
            </div>
          </a>
        </div>
        {/* Añadir los otros enlaces si es necesario */}
      </div>
    </div>
  );
}

export default DashTrabDocLabRegla;