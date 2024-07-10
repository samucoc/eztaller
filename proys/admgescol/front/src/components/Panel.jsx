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
import Resumen from './Resumen'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Dashboard from './Dashboard'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import DashTrab from './DashTrab'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Users from './Users'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import Roles from './Roles'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import LiqAnioActual from './LiqAnioActual'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import LiqAnioAnterior from './LiqAnioAnterior'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import SolAntSue from './SolAntSue'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import SolOtros from './SolOtros'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import SolBene from './SolBene'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import SolPer from './SolPer'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import SolAntCuo from './SolAntCuo'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ComAmon from './ComAmon.jsx'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ComCumple from './ComCumple'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import ComOtras from './ComOtras'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import DashTrabDocLabRegla from './DashTrabDocLabRegla'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import DashTrabDocLabContr from './DashTrabDocLabContr'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import DashTrabDocLabReglaCarga from './DashTrabDocLabReglaCarga'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import DashTrabDocLabReglaFunGen from './DashTrabDocLabReglaFunGen'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import DashTrabDocLabReglaRIOHS from './DashTrabDocLabReglaRIOHS'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import DashTrabDocLabContrCopia from './DashTrabDocLabContrCopia'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import DashTrabDocLabContrFirmar from './DashTrabDocLabContrFirmar'; // Asegúrate de importar correctamente el componente LiquidacionesToPdf
import '../css/Panel.css';

const Panel = ({ currentOption, userDNI, empresaId, setCurrentOption}) => {
  const handleOptionChange = (option) => {
    setCurrentOption(option);
  };
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
      case 'Resumen':
        return <Resumen userDNI={userDNI}  empresaId={empresaId}/>;    
      case 'Dashboard':
        return <Dashboard userDNI={userDNI}  empresaId={empresaId}/>;    
      case 'DashTrab' : 
        return <DashTrab userDNI={userDNI} onOptionChange={handleOptionChange} />;                      
      case 'Users' : 
        return <Users />;
      case 'Roles' : 
        return <Roles />;
      case 'LiqAnioActual' : 
        return <LiqAnioActual />;
      case 'LiqAnioAnterior' : 
        return <LiqAnioAnterior />;
      case 'SolAntSue' : 
        return <SolAntSue />;
      case 'SolAntCuo' : 
        return <SolAntCuo />;
        case 'SolPer' : 
        return <SolPer />;
      case 'SolBene' : 
        return <SolBene />;
      case 'SolOtros' : 
        return <SolOtros />;
      case 'ComAmon' : 
        return <ComAmon />;
      case 'ComCumple' : 
        return <ComCumple />;
      case 'ComOtras' : 
        return <ComOtras />;
      case 'DashTrabDocLabRegla' : 
        return <DashTrabDocLabRegla />;
      case 'DashTrabDocLabContr' : 
        return <DashTrabDocLabContr />;
      case 'DashTrabDocLabReglaCarga' : 
        return <DashTrabDocLabReglaCarga />;
      case 'DashTrabDocLabReglaFunGen' : 
        return <DashTrabDocLabReglaFunGen />;
      case 'DashTrabDocLabReglaRIOHS' : 
        return <DashTrabDocLabReglaRIOHS />;
      case 'DashTrabDocLabContrCopia' : 
        return <DashTrabDocLabContrCopia />;
      case 'DashTrabDocLabContrFirmar' : 
        return <DashTrabDocLabContrFirmar />;
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