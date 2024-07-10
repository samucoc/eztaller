import React, { useState, useEffect } from 'react';
import '../css/DashTrab.css'; // Si tienes estilos adicionales para DashTrab

const DashTrabCom = ({ userDNI, onOptionChange }) => {
  const [showDashTrabRegla, setshowDashTrabRegla] = useState(true);
  const [showDashTrabContr, setshowDashTrabContr] = useState(true);


  return (
    <div className="menu-container d-flex justify-content-center align-items-center">
      <div className="row w-100">
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('ComAmon')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/contrato.png" className="img-fluid mb-2" alt="Amonestación"/>
              <span>Amonestación</span>
            </div>
          </a>
        </div>
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('ComCumple')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Cumpleaños"/>
              <span>Cumpleaños</span>
            </div>
          </a>
        </div>
        <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
          <a onClick={() => onOptionChange('ComOtras')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Otras"/>
              <span>Otras</span>
            </div>
          </a>
        </div>
        {/* Añadir los otros enlaces si es necesario */}
      </div>
    </div>
  );
}

export default DashTrabCom;