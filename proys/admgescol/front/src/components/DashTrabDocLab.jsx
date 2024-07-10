import React, { useState, useEffect } from 'react';
import '../css/DashTrab.css'; // Si tienes estilos adicionales para DashTrab
import Breadcrumbs from './Breadcrumbs';
import DashTrabDocLabContr from './DashTrabDocLabContr';
import DashTrabDocLabRegla from './DashTrabDocLabRegla';

const DashTrabDocLab = ({ userDNI, onOptionChange, currentOption, onHomeClick }) => {
  const [showDashTrabRegla, setshowDashTrabRegla] = useState(true);
  const [showDashTrabContr, setshowDashTrabContr] = useState(true);

  const [currentSection, setCurrentSection] = useState('menu'); // default section is menu

  const handleOptionChange = (section) => {
    setCurrentSection(section); // Update the current section
  };

  return (
    <div className="menu-container d-flex justify-content-center align-items-center">
      <div className="row w-100">
        {currentSection === 'menu' && (
          <>
            <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
              <a onClick={() => handleOptionChange('DashTrabDocLabContr')} className="btn btn-link text-center">
                <div className="icon-text">
                  <img src="images_gescol/fin_comp/contrato.png" className="img-fluid mb-2" alt="Contrato de Trabajo" />
                  <span>Contrato de Trabajo</span>
                </div>
              </a>
            </div>
            <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
              <a onClick={() => handleOptionChange('DashTrabDocLabRegla')} className="btn btn-link text-center">
                <div className="icon-text">
                  <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Reglamentos Internos" />
                  <span>Reglamentos Internos</span>
                </div>
              </a>
            </div>
            
          </>
        )}

        {currentSection === 'DashTrabDocLabContr' && (
          <>
            <DashTrabDocLabContr userDNI={userDNI} onOptionChange={onOptionChange} currentOption={currentOption} onHomeClick={() => handleOptionChange('menu')} />
          </>
        )}

        {currentSection === 'DashTrabDocLabRegla' && (
          <>
            <DashTrabDocLabRegla userDNI={userDNI} onOptionChange={onOptionChange} currentOption={currentOption} onHomeClick={() => handleOptionChange('menu')} />
          </>
        )}
        {/* Añadir los otros enlaces si es necesario */}
      </div>
    </div>
  );
}

export default DashTrabDocLab;
