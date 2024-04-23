import React from 'react';
import LiquidacionesToPdf from './LiquidacionesToPdf'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ListadoDocumentos from './ListadoDocumentos'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ListadoContratos from './ListadoContratos'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ListadoReglamento from './ListadoReglamento'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Documentos from './Documentos'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Trabajadores from './Trabajadores'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Comunas from './Comunas'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Cargos from './Cargos'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Sexo from './Sexo'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Tipo_Docs from './Tipo_Docs'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Empresas from './Empresas'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import '../css/Panel.css';

const Panel = ({ currentOption, userDNI, empresaId}) => {
  const renderContent = () => {
    switch (currentOption) {
      case 'LiquidacionesToPdf':
        return <LiquidacionesToPdf />;
      case 'ListadoDocumentos':
        return <ListadoDocumentos userDNI={userDNI}  empresaId={empresaId}/>;
      case 'ListadoContratos':
        return <ListadoContratos userDNI={userDNI}  empresaId={empresaId}/>;
      case 'ListadoReglamento':
          return <ListadoReglamento userDNI={userDNI}  empresaId={empresaId}/>;
      case 'Documentos':
        return <Documentos  empresaId={empresaId} />;
      case 'Trabajadores':
        return <Trabajadores  empresaId={empresaId}/>;
      case 'Comunas':
        return <Comunas />;
      case 'Cargos':
        return <Cargos />;
      case 'Sexo':
        return <Sexo />;
      case 'Tipo_Docs':
        return <Tipo_Docs />;         
      case 'Empresas':
        return <Empresas />;    
            
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