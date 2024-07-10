import React, { useState, useEffect } from 'react';
import '../css/DashTrab.css'; // Si tienes estilos adicionales para DashTrab

const DashTrabDocLabReglaFunGen = ({ userDNI, onOptionChange }) => {
  const [showDashTrabRegla, setshowDashTrabRegla] = useState(true);
  const [showDashTrabContr, setshowDashTrabContr] = useState(true);

  const currentYear = new Date().getFullYear();
  const previousYear = currentYear - 1;

  return (
    <div className="menu-container d-flex justify-content-center align-items-center">
      <div className="row w-100">
      DashTrabDocLabReglaFunGen
        {/* Añadir los otros enlaces si es necesario */}
      </div>
    </div>
  );
}

export default DashTrabDocLabReglaFunGen;