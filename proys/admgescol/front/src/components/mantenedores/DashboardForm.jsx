import React, { useState, useEffect } from 'react';
import {Select, MenuItem, Button, TextField, Grid } from '@material-ui/core';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
const DashboardForm = ({ onSubmit, onCancel, initialDoc, empresaId }) => {
    const [meses, setMeses] = useState([]);
    const [agnios, setAgnios] = useState([]);
    const [tipoDocumentos, setTipoDocumentos] = useState([]);
    const [workers, setWorkers] = useState([]); // State to store worker data
  
    const [mes, setMes] = useState(initialDoc ? initialDoc.mes : '');
    const [agno, setAgnio] = useState(initialDoc ? initialDoc.agno : '');
    const [tipo, setTipo] = useState(initialDoc ? initialDoc.tipo_doc_id : '');
    const [nombre, setNombre] = useState(initialDoc ? initialDoc.nombre : '');
    const [trabajador, setTrabajador] = useState(initialDoc ? initialDoc.trabajador : '');
    const [file, setFile] = useState(initialDoc ? initialDoc.file : '');
    
    // Fetch all workers on component mount
      useEffect(() => {
          const fetchWorkers = async () => {
              try {
              const response = await axios.get(`${API_BASE_URL}/trabajadores`); // Assuming your worker endpoint is at /trabajadores
              setWorkers(response.data);
              } catch (error) {
              console.error('Error fetching workers:', error);
              }
          };
  
          fetchWorkers();
  
          const fetchTipoDocumentos = async () => {
            try {
              const response = await axios.get(`${API_BASE_URL}/tipo_doc`);
              setTipoDocumentos(response.data);
            } catch (error) {
              console.error('Error fetching tipo_doc:', error);
            }
          };
      
          fetchTipoDocumentos();
  
          const fetchMeses = () => {
            const months = [
              { value: '1', label: 'Enero' },
              { value: '2', label: 'Febrero' },
              { value: '3', label: 'Marzo' },
              { value: '4', label: 'Abril' },
              { value: '5', label: 'Mayo' },
              { value: '6', label: 'Junio' },
              { value: '7', label: 'Julio' },
              { value: '8', label: 'Agosto' },
              { value: '9', label: 'Septiembre' },
              { value: '10', label: 'Octubre' },
              { value: '11', label: 'Noviembre' },
              { value: '12', label: 'Diciembre' }
            ];
            setMeses(months);
          };
      
          const fetchAgnios = () => {
            const currentYear = new Date().getFullYear();
            const years = [
              { value: currentYear - 1, label: currentYear - 1 },
              { value: currentYear, label: currentYear },
              { value: currentYear + 1, label: currentYear + 1 }
            ];
            setAgnios(years);
          };

          fetchMeses();
          fetchAgnios();

          }, []);

    const handleFileChange = (e) => {
        const selectedFile = e.target.files[0];
        setFile(selectedFile);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit({ mes, agno, tipo, trabajador, nombre, file });
    };

  return (
    <form onSubmit={handleSubmit}>
      <Grid container spacing={2} alignItems="center">
        <Grid item xs={12} sm={6}>
          <Select
            variant="outlined"
            
            fullWidth
            id="mes"
            label="Mes"
            name="mes"
            select
            value={mes}
            onChange={(e) => setMes(e.target.value)}
          >
            <MenuItem value="">Seleccionar mes...</MenuItem>
            {meses.map((option) => (
              <MenuItem key={option.value} value={option.value}>
                {option.label}
              </MenuItem>
            ))}
          </Select>
        </Grid>
        <Grid item xs={12} sm={6}>
          <Select
            variant="outlined"
            
            fullWidth
            id="agnio"
            label="Año"
            name="agnio"
            select
            value={agno}
            onChange={(e) => setAgnio(e.target.value)}
          >
            <MenuItem value="">Seleccionar año...</MenuItem>
            {agnios.map((option) => (
              <MenuItem key={option.value} value={option.value}>
                {option.label}
              </MenuItem>
            ))}
          </Select>
        </Grid>
        <Grid item xs={12}>
          <Select
            variant="outlined"
            
            fullWidth
            id="tipo"
            label="Tipo"
            name="tipo"
            select
            value={tipo}
            onChange={(e) => setTipo(e.target.value)}
          >
            <MenuItem value="">Seleccionar tipo...</MenuItem>
            {tipoDocumentos.map((tipo) => (
              <MenuItem key={tipo.id} value={tipo.id}>
                {tipo.nombre}
              </MenuItem>
            ))}
          </Select>
        </Grid>
        <Grid item xs={12}>
          <Select
            variant="outlined"
            
            fullWidth
            id="trabajador"
            label="Trabajador"
            name="trabajador"
            select
            value={trabajador}
            onChange={(e) => setTrabajador(e.target.value)}
          >
            <MenuItem value="">Seleccionar trabajador...</MenuItem>
            {empresaId
              ? 
                workers
                  .filter((worker) => worker.empresa_id === empresaId)
                  .map((worker) => (
                  <MenuItem key={worker.rut} value={worker.rut}>
                    {`${worker.rut} - ${worker.nombres} ${worker.apellido_paterno} ${worker.apellido_materno}`}
                  </MenuItem>
              ))
              :
              workers
              .map((worker) => (
              <MenuItem key={worker.rut} value={worker.rut}>
                {`${worker.rut} - ${worker.nombres} ${worker.apellido_paterno} ${worker.apellido_materno}`}
              </MenuItem>
            ))}
          </Select>
        </Grid>
        <Grid item xs={12}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="nombre"
            label="Nombre"
            name="nombre"
            value={nombre}
            onChange={(e) => setNombre(e.target.value)}
          />
        </Grid>
        <Grid item xs={12}>
          <input
            type="file"
            id="file"
            className="form-control"
            accept=".pdf"
            onChange={handleFileChange}
          />
        </Grid>
        <Grid item xs={6}>
          <Button
            type="submit"
            fullWidth
            variant="contained"
            color="primary"
          >
            Guardar
          </Button>
        </Grid>
        <Grid item xs={6}>
          <Button
            fullWidth
            variant="contained"
            onClick={onCancel}
          >
            Cancelar
          </Button>
        </Grid>
        <Grid item xs={12}>
          <Button
            fullWidth
            variant="outlined"
            onClick={onCancel} // Cambiar esto a la función para volver a la lista de documentos
          >
            Volver a la lista de Documentos
          </Button>
        </Grid>
      </Grid>
    </form>
  );
};

export default DashboardForm;