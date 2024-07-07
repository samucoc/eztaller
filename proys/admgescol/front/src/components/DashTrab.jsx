import React from 'react';
import '../css/DashTrab.css'; // Si tienes estilos adicionales para DashTrab

const DashTrab = ({ userDNI, onOptionChange }) => {
  return (
    <div className="menu-container d-flex justify-content-center align-items-center">
      <div className="row w-100">
        <div className="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
          <a onClick={() => onOptionChange('Resumen')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/gest_esc/ficha-apoderado.png" className="img-fluid mb-2" alt="Datos Personales"/>
              <span>Datos Personales</span>
            </div>
          </a>
        </div>
        <div className="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
          <a onClick={() => onOptionChange('ListadoReglamento')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/contrato.png" className="img-fluid mb-2" alt="Documentos Laborales"/>
              <span>Documentos Laborales</span>
            </div>
          </a>
        </div>
        <div className="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
          <a onClick={() => onOptionChange('ListadoDocumentos')} className="btn btn-link text-center">
            <div className="icon-text">
              <img src="images_gescol/fin_comp/pagos.png" className="img-fluid mb-2" alt="Liquidaciones"/>
              <span>Liquidaciones</span>
            </div>
          </a>
        </div>
        {/* Añadir los otros enlaces si es necesario */}
      </div>
    </div>
  );
}

export default DashTrab;
