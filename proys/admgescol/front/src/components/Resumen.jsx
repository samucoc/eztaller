import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Accordion from '@mui/material/Accordion';
import AccordionSummary from '@mui/material/AccordionSummary';
import AccordionDetails from '@mui/material/AccordionDetails';
import Typography from '@mui/material/Typography';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import API_BASE_URL from './apiConstants'; // Asegúrate de importar la URL base de tu API
import API_DOWNLOAD_URL from './apiConstants1'; // Asegúrate de importar la URL de descarga de tu API
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faEye } from '@fortawesome/free-solid-svg-icons';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';


const Resumen = ({ userDNI, empresaId }) => {
  const [worker, setWorker] = useState(null);
  const [liquidations, setLiquidations] = useState([]);
  const [contracts, setContracts] = useState([]);
  const [others, setOthers] = useState([]);
  const [previewPdf, setPreviewPdf] = useState(null);
  const [expanded, setExpanded] = useState('panel1'); // Estado para el acordeón expandido

  useEffect(() => {
    const fetchData = async () => {
      try {
        const workerResponse = await axios.get(API_BASE_URL+`/trabajadores/showByRut/${userDNI}`);
        setWorker(workerResponse.data);

        const liquidationsResponse = await axios.get(`${API_BASE_URL}/documentos/showLiquidaciones/${userDNI}`);
        setLiquidations(liquidationsResponse.data);

        const contractsResponse =  await axios.get(`${API_BASE_URL}/documentos/showContratos/${userDNI}`);
        setContracts(contractsResponse.data);

        const othersResponse = await axios.get(`${API_BASE_URL}/documentos/showReglamento/${userDNI}`);
        setOthers(othersResponse.data);
      } catch (error) {
        console.error('Error fetching data', error);
      }
    };

    fetchData();
  }, [userDNI, empresaId]);

  if (!worker) {
    return <div>Loading...</div>;
  }
  const handleChange = (panel) => (event, isExpanded) => {
    setExpanded(isExpanded ? panel : false);
  };

  return (
    <div>
      <h3>Datos Personales</h3>
      <Accordion expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel1a-content"
          id="panel1a-header"
        >
          <Typography>Datos del Trabajador</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            {worker
              .slice(0,1)
              .map(d => (
                <div key={d.id}>
                  <strong>Nombre Completo:</strong> {d.nombres} {d.apellido_paterno} {d.apellido_materno} <br />
                  <strong>Rut:</strong> {d.rut}-{d.dv}<br />
                  <strong>Teléfono:</strong> {d.telefono}<br />
                  <strong>Email:</strong> {d.email}
                </div>
              ))}
          </Typography>
        </AccordionDetails>
      </Accordion>
      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>Últimas 12 Liquidaciones</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            <ul>
              {liquidations
                .slice(0, 12)
                .filter((d) => d.empresa_id === empresaId)
            .map(d => (
              <tr key={d.ruta}>
                <td>{d.mes}</td>
                <td>{d.agno}</td>
                <td>{d.nombre}</td>
                <td>
                  <a href="#"
                    className="btn btn-primary"
                    onClick={() => setPreviewPdf(`${API_DOWNLOAD_URL}/${d.ruta}`)}
                    data-bs-toggle="modal"
                    data-bs-target="#pdfModal"
                  >
                    <FontAwesomeIcon icon={faEye} /> Ver Archivo
                  </a>
                </td>
              </tr>
            ))}
            </ul>
          </Typography>
        </AccordionDetails>
      </Accordion>
      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel3a-content"
          id="panel3a-header"
        >
          <Typography>Contratos</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            <ul>
              {contracts
              .filter((d) => d.empresa_id === empresaId)
              .map((d) => (
              <tr key={d.ruta}>
                <td>{d.mes}</td>
                <td>{d.agno}</td>
                <td>{d.nombre}</td>
                <td>
                  <a href="#"
                    className="btn btn-primary"
                    onClick={() => setPreviewPdf(`${API_DOWNLOAD_URL}/${d.ruta}`)}
                    data-bs-toggle="modal"
                    data-bs-target="#pdfModal"
                  >
                    <FontAwesomeIcon icon={faEye} /> Ver Archivo
                  </a>
                </td>
              </tr>
            ))}
            </ul>
          </Typography>
        </AccordionDetails>
      </Accordion>
      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel4a-content"
          id="panel4a-header"
        >
          <Typography>Otros Documentos</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            <ul>
              {others
               .filter((d) => d.empresa_id === empresaId)
               .map(d => (
                 <tr key={d.ruta}>
                   <td>{d.mes}</td>
                   <td>{d.agno}</td>
                   <td>{d.nombre}</td>
                   <td>
                     <a href="#"
                       className="btn btn-primary"
                       onClick={() => setPreviewPdf(`${API_DOWNLOAD_URL}/${d.ruta}`)}
                       data-bs-toggle="modal"
                       data-bs-target="#pdfModal"
                     >
                       <FontAwesomeIcon icon={faEye} /> Ver Archivo
                     </a>
                   </td>
                 </tr>
               ))}
            </ul>
          </Typography>
        </AccordionDetails>
      </Accordion>
    </div>
  );
};

export default Resumen;