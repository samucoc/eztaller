import React, { useState } from 'react';
import '../css/DashTrab.css'; // Si tienes estilos adicionales para DashTrab
import Breadcrumbs from './Breadcrumbs';
import DashTrabDocLab from './DashTrabDocLab';
import DashTrabLiq from './DashTrabLiq';
import DashTrabSol from './DashTrabSol';
import DashTrabCom from './DashTrabCom';

const DashTrab = ({ userDNI, onOptionChange, currentOption, onHomeClick }) => {
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
              <a onClick={() => handleOptionChange('DocumentosLaborales')} className="btn btn-link text-center">
                <div className="icon-text">
                  <img src="images_gescol/fin_comp/contrato.png" className="img-fluid mb-2" alt="Documentos Laborales" />
                  <span>Documentos Laborales</span>
                </div>
              </a>
            </div>
            <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
              <a onClick={() => handleOptionChange('ListadoDocumentos')} className="btn btn-link text-center">
                <div className="icon-text">
                  <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Liquidaciones" />
                  <span>Liquidaciones</span>
                </div>
              </a>
            </div>
            <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
              <a onClick={() => handleOptionChange('Solicitudes')} className="btn btn-link text-center">
                <div className="icon-text">
                  <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Solicitudes" />
                  <span>Solicitudes</span>
                </div>
              </a>
            </div>
            <div className="col-6 col-sm-6 col-md-6 d-flex justify-content-center">
              <a onClick={() => handleOptionChange('ComunicacionEmpleador')} className="btn btn-link text-center">
                <div className="icon-text">
                  <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Comunicación Empleador" />
                  <span>Comunicación Empleador</span>
                </div>
              </a>
            </div>
          </>
        )}

        {currentSection === 'DocumentosLaborales' && (
          <>
            <Breadcrumbs currentOption={currentOption} onHomeClick={() => handleOptionChange('menu')} />
            <DashTrabDocLab userDNI={userDNI} onOptionChange={onOptionChange} currentOption={currentOption} onHomeClick={() => handleOptionChange('menu')} />
          </>
        )}

        {currentSection === 'ListadoDocumentos' && (
          <>
            <Breadcrumbs currentOption={currentOption} onHomeClick={() => handleOptionChange('menu')} />
            <DashTrabLiq userDNI={userDNI} onOptionChange={onOptionChange} />
          </>
        )}

        {currentSection === 'Solicitudes' && (
          <>
            <Breadcrumbs currentOption={currentOption} onHomeClick={() => handleOptionChange('menu')} />
            <DashTrabSol userDNI={userDNI} onOptionChange={onOptionChange} />
          </>
        )}

        {currentSection === 'ComunicacionEmpleador' && (
          <>
            <Breadcrumbs currentOption={currentOption} onHomeClick={() => handleOptionChange('menu')} />
            <DashTrabCom userDNI={userDNI} onOptionChange={onOptionChange} />
          </>
        )}
      </div>
    </div>
  );
};

export default DashTrab;
