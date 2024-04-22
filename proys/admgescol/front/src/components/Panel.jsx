import React from 'react';
import LiquidacionesToPdf from './LiquidacionesToPdf'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ListadoDocumentos from './ListadoDocumentos'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ListadoContratos from './ListadoContratos'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ListadoReglamento from './ListadoReglamento'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Documentos from './Documentos'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Trabajadores from './Trabajadores'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import '../css/Panel.css';

const Panel = ({ currentOption, userDNI}) => {
  const renderContent = () => {
    switch (currentOption) {
      case 'LiquidacionesToPdf':
        return <LiquidacionesToPdf />;
      case 'ListadoDocumentos':
        return <ListadoDocumentos userDNI={userDNI} />;
      case 'ListadoContratos':
        return <ListadoContratos userDNI={userDNI} />;
      case 'ListadoReglamento':
          return <ListadoReglamento userDNI={userDNI} />;
      case 'Documentos':
        return <Documentos />;
      case 'Trabajadores':
        return <Trabajadores />;
      default:
        return <h1>{currentOption}</h1>;
    }
  };

  return (
    <div className="panel">
      {renderContent()}
    </div>
  );
}

export default Panel;