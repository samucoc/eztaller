import React, { useState, useEffect } from 'react';
import '../../css/DashTrab.css'; // Si tienes estilos adicionales para DashTrab

const DashTrabSol = ({ userDNI, onOptionChange }) => {
  const [showDashTrabRegla, setshowDashTrabRegla] = useState(true);
  const [showDashTrabContr, setshowDashTrabContr] = useState(true);


  return (
    <div className="menu-container d-flex justify-content-center align-items-center">
      <div className="row w-100">
      <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('SolAntSue')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/contrato.png" className="img-fluid mb-2" alt="Anticipo Sueldo Mes"/>
              <span>Anticipo Sueldo Mes</span>
            </div>
          </a>
        </div>
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('SolAntCuo')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Anticipo Cuotas"/>
              <span>Anticipo Cuotas</span>
            </div>
          </a>
        </div>
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('SolPer')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/contrato.png" className="img-fluid mb-2" alt="Permisos"/>
              <span>Permisos</span>
            </div>
          </a>
        </div>
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('SolBene')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Beneficios"/>
              <span>Beneficios</span>
            </div>
          </a>
        </div>
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('SolOtros')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Otros"/>
              <span>Otros</span>
            </div>
          </a>
        </div>
        {/* Añadir los otros enlaces si es necesario */}
      </div>
    </div>
  );
}

export default DashTrabSol;