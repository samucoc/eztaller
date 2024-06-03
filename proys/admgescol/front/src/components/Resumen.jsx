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
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import MenuItem from '@material-ui/core/MenuItem';

const Resumen = ({ userDNI, empresaId }) => {
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

    fetchData();
    fetchEmpresas();
    fetchUsuarios();
    fetchCargos();
    fetchSexos();
    fetchComunas();

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
                  <Grid container spacing={2} alignItems="center">
                    <Grid item xs={12} sm={6}>
                    <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="empresa_id"
                        label="Empresa"
                        name="empresa_id"
                        select
                        value={d.empresa_id}
                        onChange={handleChange}
                      >
                      {empresaId === ''
                        ? empresas.map((empresa) => (
                            <MenuItem
                              key={empresa.id}
                              value={empresa.id}
                              selected={worker && empresa.id === worker.empresa_id}
                            >
                              {empresa.RazonSocial}
                            </MenuItem>
                          ))
                        : empresas
                            .filter((empresa) => empresa.id === empresaId)
                            .map((empresa) => (
                              <MenuItem
                                key={empresa.id}
                                value={empresa.id}
                                selected={worker && empresa.id === worker.empresa_id}
                              >
                                {empresa.RazonSocial}
                              </MenuItem>
                            ))}
                      </TextField>
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="user_id"
                        label="Usuario"
                        name="user_id"
                        select
                        value={d.user_id}
                        onChange={handleChange}
                      >
                        {usuarios.map((usuario) => (
                          <MenuItem key={usuario.id} value={usuario.id} selected={worker && usuario.id === worker.user_id}>
                            {usuario.userEmail}
                          </MenuItem>
                        ))}
                      </TextField>
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="rut"
                        label="Rut"
                        name="rut"
                        value={d.rut}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="dv"
                        label="Dv"
                        name="dv"
                        value={d.dv}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="apellido_paterno"
                        label="Apellido Paterno"
                        name="apellido_paterno"
                        value={d.apellido_paterno}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="apellido_materno"
                        label="Apellido Materno"
                        name="apellido_materno"
                        value={d.apellido_materno}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="nombres"
                        label="Nombres"
                        name="nombres"
                        value={d.nombres}
                        onChange={handleChange}
                      />
                    </Grid>       
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="nombre_social"
                        label="Nombre Social"
                        name="nombre_social"
                        value={d.nombre_social}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="fecha_nac"
                        label="Fecha de Nacimiento"
                        name="fecha_nac"
                        type="date"
                        InputLabelProps={{
                          shrink: true,
                        }}
                        value={d.fecha_nac}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="nacionalidad"
                        label="Nacionalidad"
                        name="nacionalidad"
                        value={d.nacionalidad}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="cargo_id"
                        label="Cargo"
                        name="cargo_id"
                        select
                        value={d.cargo_id}
                        onChange={handleChange}
                      >
                        {cargos.map((cargo) => (
                          <MenuItem key={cargo.id} value={cargo.id} selected={worker && cargo.id === worker.cargo_id}>
                            {cargo.nombre}
                          </MenuItem>
                        ))}
                      </TextField>
                    </Grid>      
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="sexo_id"
                        label="Sexo"
                        name="sexo_id"
                        select
                        value={d.sexo_id}
                        onChange={handleChange}
                      >
                        {sexos.map((sexo) => (
                          <MenuItem key={sexo.id} value={sexo.id} selected={worker && sexo.id === worker.sexo_id}>
                            {sexo.nombre}
                          </MenuItem>
                        ))}
                      </TextField>
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        type="file"
                        id="foto"
                        label="foto"
                        name="foto"
                        value={d.foto}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="direccion"
                        label="Dirección"
                        name="direccion"
                        value={d.direccion}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="comuna_id"
                        label="Comuna"
                        name="comuna_id"
                        select
                        value={d.comuna_id}
                        onChange={handleChange}
                      >
                        {comunas.map((comuna) => (
                          <MenuItem key={comuna.id} value={comuna.id} selected={worker && comuna.id === worker.comuna_id}>
                            {comuna.nombre}
                          </MenuItem>
                        ))}
                      </TextField>
                    </Grid>        
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="telefono"
                        label="Teléfono"
                        name="telefono"
                        value={d.telefono}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="email"
                        label="Email"
                        name="email"
                        value={d.email}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="contacto_emergencia"
                        label="Contacto Emergencia"
                        name="contacto_emergencia"
                        value={d.contacto_emergencia}
                        onChange={handleChange}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="telefono_emergencia"
                        label="Teléfono Emergencia"
                        name="telefono_emergencia"
                        value={d.telefono_emergencia}
                        onChange={handleChange}
                      />
                    </Grid>        
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        InputProps={{
                          readOnly: true,
                        }}
                        fullWidth
                        id="estado_id"
                        label="Estado"
                        name="estado_id"
                        value={d.estado_id}
                        onChange={handleChange}
                      />
                    </Grid>
                  </Grid>
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