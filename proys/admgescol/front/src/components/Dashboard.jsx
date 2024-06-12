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

const Dashboard = ({ userDNI, empresaId }) => {
  const [worker, setWorker] = useState(null);
  const [liquidations, setLiquidations] = useState([]);
  const [contracts, setContracts] = useState([]);
  const [others, setOthers] = useState([]);
  const [previewPdf, setPreviewPdf] = useState(null);
  const [expanded, setExpanded] = useState('panel1'); // Estado para el acordeón expandido
  const [empresas, setEmpresas] = useState([]);
  const [usuarios, setUsuarios] = useState([]);
  const [cargos, setCargos] = useState([]);
  const [sexos, setSexos] = useState([]);
  const [comunas, setComunas] = useState([]);
  const [tipoDocumentos, setTipoDocumentos] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const liquidationsResponse = await axios.get(`${API_BASE_URL}/documentos`);
        setLiquidations(liquidationsResponse.data);

      } catch (error) {
        console.error('Error fetching data', error);
      }
    };
    const fetchEmpresas = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/empresas`);
        setEmpresas(response.data);
      } catch (error) {
        console.error('Error al obtener la lista de empresas:', error);
      }
    };
  
    const fetchUsuarios = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/users`);
        setUsuarios(response.data);
      } catch (error) {
        console.error('Error al obtener la lista de usuarios:', error);
      }
    };
  
    const fetchCargos = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/cargos`);
        setCargos(response.data);
      } catch (error) {
        console.error('Error al obtener la lista de cargos:', error);
      }
    };
  
    const fetchSexos = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/sexo`);
        setSexos(response.data);
      } catch (error) {
        console.error('Error al obtener la lista de sexos:', error);
      }
    };
  
    const fetchComunas = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/comunas`);
        setComunas(response.data);
      } catch (error) {
        console.error('Error al obtener la lista de comunas:', error);
      }
    };

    const fetchTipoDocumentos = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/tipo_doc`);
        setTipoDocumentos(response.data);
      } catch (error) {
        console.error('Error fetching tipo_doc:', error);
      }
    };

    fetchTipoDocumentos();

    fetchData();
    fetchEmpresas();
    fetchUsuarios();
    fetchCargos();
    fetchSexos();
    fetchComunas();

  }, [userDNI, empresaId]);

  const handleChange = (panel) => (event, isExpanded) => {
    setExpanded(isExpanded ? panel : false);
  };

  const getTipoDocumentoNombre = (tipoDocId) => {
    const tipoDoc = tipoDocumentos.find((tipo) => tipo.id === tipoDocId);
    return tipoDoc ? tipoDoc.nombre : 'Desconocido';
  };

  return (
    <div>
      <h3>Dashboard</h3>
      <Accordion expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel1a-content"
          id="panel1a-header"
        >
          <Typography>Documentos</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
          <table className="table">
            <thead>
              <tr>
                <th>Mes</th>
                <th>Año</th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Ruta</th>
              </tr>
            </thead>
            <tbody>
              {liquidations
                .filter((d) => d.empresa_id === empresaId)
                .map(d => (
                  <tr key={d.ruta}>
                    <td>{d.mes}</td>
                    <td>{d.agno}</td>
                    <td>{getTipoDocumentoNombre(d.tipo_doc_id)}</td>
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
            </tbody>
          </table>
          </Typography>
        </AccordionDetails>
      </Accordion>
    </div>
  );
};

export default Dashboard;