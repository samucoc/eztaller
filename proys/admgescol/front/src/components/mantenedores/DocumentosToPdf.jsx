// components/DocumentosToPdf.jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../../css/LiquidacionesToPdf.css';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import {
  Card, CardContent, Container,
  Typography,
  FormControl,
  InputLabel,
  Select,
  MenuItem,
  Button,
  CircularProgress,
  TextField,
  Box,
  Grid,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,

} from '@mui/material';
import swal from 'sweetalert2';
import Loader from 'react-loader-spinner';
import { useSelector } from 'react-redux'; // Importar useSelector

const DocumentosToPdf = () => {
  const [empresa_id, setEmpresa_Id] = useState('');
  const [month, setMonth] = useState('');
  const [year, setYear] = useState('');
  const [file, setFile] = useState(null);
  const [loading, setLoading] = useState(false);
  const [empresas, setEmpresas] = useState([]);
  const [tipoDocumentos, setTipoDocumentos] = useState([]);
  const [tipo_doc_id, settipo_doc_id] = useState('');
  const [trabajadores, setTrabajadores] = useState([]);
  const [trabajador, setTrabajador] = useState('');
  const [nombre, setNombre] = useState('');
  const empresaIdS = useSelector((state) => state.empresaId); // Obtener empresaId de Redux

  const fetchEmpresas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/empresas`);
      setEmpresas(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de empresas:', error);
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

  const fetchTrabajadores = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/trabajadores`);
      setTrabajadores(response.data);
    } catch (error) {
      console.error('Error fetching trabajadores:', error);
    }
  };

  useEffect(() => {
    fetchEmpresas();
    fetchTipoDocumentos();
    fetchTrabajadores();
  }, []);

  const handleMonthChange = (event) => {
    setMonth(event.target.value);
  };

  const handleEmpresaChange = (event) => {
    setEmpresa_Id(event.target.value);
  };

  const handleYearChange = (event) => {
    setYear(event.target.value);
  };

  const handleFileChange = (event) => {
    setFile(event.target.files[0]); // Almacena el primer archivo seleccionado
  };

  const handleTipoDocChange = (event) => {
    settipo_doc_id(event.target.value);
  };

  const handleTrabajadorChange = (event) => {
    setTrabajador(event.target.value);
  };

  const handleNombreChange = (event) => {
    setNombre(event.target.value);
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    if (!month || !year || !file) {
      alert('Por favor, complete todos los campos.');
      return;
    }

    const formData = new FormData();
    formData.append('empresa_id', empresaIdS ? empresaIdS : empresa_id);
    formData.append('tipo_doc_id', tipo_doc_id);
    formData.append('month', month);
    formData.append('year', year);
    formData.append('trabajador', trabajador);
    formData.append('nombre', nombre);
    formData.append('file', file); // Agrega el archivo al FormData

    try {
      // Mostrar mensaje de "Cargando"
      swal.fire({
        title: 'Cargando',
        text: 'Por favor, espere mientras se suben los datos...',
        allowOutsideClick: false,
        didOpen: () => {
          swal.showLoading();
        }
      });

      setLoading(true);
      const response = await axios.post(`${API_BASE_URL}/documentos`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      console.log('Respuesta del servidor:', response.data);
      swal.fire("Correcto", response.message, "success");

      setLoading(false);
    } catch (error) {
      console.error('Error al enviar los datos:', error);
      swal.fire("Error", "Error al enviar los datos.", "error");

      setLoading(false);
    }
  };

  const getLastTenYears = () => {
    const currentYear = new Date().getFullYear();
    const years = [];
    
    for (let i = 0; i < 10; i++) {
      years.push(currentYear - i);
    }
    
    return years;
  };
  
  return (
    <Card sx={{ maxWidth: 800, margin: 'auto', padding: 2 }}>
      <CardContent>
        <Container className="liquidaciones-to-pdf" maxWidth="sm">
          <Typography variant="h4" component="h2" gutterBottom>
            Ingresar Documentos Individuales
          </Typography>
          <form onSubmit={handleSubmit}>
            {empresaIdS ? (
                <TextField
                variant="outlined"
                fullWidth
                id="empresa_id"
                name="empresa_id"
                type="hidden"
                value={empresaIdS}
                InputLabelProps={{ shrink: true }}
                sx={{ display: 'none' }}
              />
            ) : (
              <Box mb={3}>
                <TextField
                  variant="outlined"
                  fullWidth
                  id="empresa_id"
                  label="Empresa"
                  name="empresa_id"
                  select
                  value={empresa_id}
                  onChange={handleEmpresaChange}
                  sx={{ color: 'black' }}  
                >
                  {empresas.map((empresa) => (
                    <MenuItem key={empresa.id} value={empresa.id}>
                      {empresa.RazonSocial}
                    </MenuItem>
                  ))}
                </TextField>
              </Box>
            )}
            <Box mb={3}>
              <FormControl fullWidth variant="outlined" margin="normal">
                <InputLabel id="tipo_doc-label">Tipo Documento</InputLabel>
                <Select
                  labelId="tipo_doc-label"
                  id="tipo_doc_id"
                  value={tipo_doc_id}
                  onChange={handleTipoDocChange}
                  label="Tipo Documento"
                >
                  <MenuItem value="">
                    <em>Seleccionar Tipo Documento...</em>
                  </MenuItem>
                  {tipoDocumentos
                    .filter( (tipo) => tipo.id !== "1" && tipo.id !== "5"  && tipo.id !== "6" )
                    .map((tipo) => (
                    <MenuItem value={tipo.id} key={tipo.id}>
                      {tipo.nombre}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            </Box>
            <Grid container spacing={2} mb={3}>
                <Grid item xs={6}>
                  <FormControl fullWidth variant="outlined" margin="normal">
                    <InputLabel id="month-label">Mes</InputLabel>
                    <Select
                      labelId="month-label"
                      id="month"
                      value={month}
                      onChange={handleMonthChange}
                      label="Mes"
                      sx={{
                        color: 'black',
                        '& .MuiSelect-select': {
                          color: 'black',
                        },
                      }}
                    >
                      <MenuItem value="">
                        <em>Seleccionar mes...</em>
                      </MenuItem>
                      <MenuItem value="1">Enero</MenuItem>
                      <MenuItem value="2">Febrero</MenuItem>
                      <MenuItem value="3">Marzo</MenuItem>
                      <MenuItem value="4">Abril</MenuItem>
                      <MenuItem value="5">Mayo</MenuItem>
                      <MenuItem value="6">Junio</MenuItem>
                      <MenuItem value="7">Julio</MenuItem>
                      <MenuItem value="8">Agosto</MenuItem>
                      <MenuItem value="9">Septiembre</MenuItem>
                      <MenuItem value="10">Octubre</MenuItem>
                      <MenuItem value="11">Noviembre</MenuItem>
                      <MenuItem value="12">Diciembre</MenuItem>
                    </Select>
                  </FormControl>
                </Grid>
                <Grid item xs={6}>
                  <FormControl variant="outlined" style={{ marginRight: '1rem', minWidth: '120px' }}>
                    <InputLabel id="year-select-label">Año</InputLabel>
                    <Select
                      labelId="year-select-label"
                      id="year"
                      value={year}
                      onChange={handleYearChange}
                      label="Año"
                    >
                      <MenuItem value="">
                        <em>Seleccionar año...</em>
                      </MenuItem>
                      {getLastTenYears().map((year) => (
                        <MenuItem key={year} value={year}>
                          {year}
                        </MenuItem>
                      ))}
                    </Select>
                  </FormControl>
                </Grid>
              </Grid>

            <Box mb={3}>
            <FormControl fullWidth variant="outlined" margin="normal">
              <InputLabel id="trabajador-label">Trabajador</InputLabel>
              <Select
                labelId="trabajador-label"
                id="trabajador"
                value={trabajador}
                onChange={handleTrabajadorChange}
                label="Trabajador"
              >
                <MenuItem value="0">
                  <em>Seleccionar trabajador...</em>
                </MenuItem>
                {trabajadores
                  .filter((trabajador) => trabajador.empresa_id === empresaIdS?empresaIdS:empresa_id)
                  .map((trabajador) => (
                    <MenuItem key={trabajador.rut} value={trabajador.rut}>
                      {trabajador.nombres} {trabajador.apellido_paterno} {trabajador.apellido_materno}
                    </MenuItem>
                  ))}
              </Select>
            </FormControl>
            </Box>
            <Box mb={3}>
              <TextField
                fullWidth
                variant="outlined"
                margin="normal"
                id="document_name"
                label="Nombre del Documento"
                value={nombre}
                onChange={handleNombreChange}
              />
            </Box>
            
            <Box mb={3}>
              <TextField
                fullWidth
                variant="outlined"
                margin="normal"
                id="file"
                label="Cargar archivo"
                type="file"
                InputLabelProps={{ shrink: true }}
                inputProps={{ accept: '.pdf' }}
                onChange={handleFileChange}
              />
            </Box>

            <Box mb={3}>
              <Button
                type="submit"
                variant="contained"
                color="primary"
                fullWidth
                disabled={loading}
                startIcon={loading && <CircularProgress size={20} />}
              >
                {loading ? 'Enviando...' : 'Generar PDF'}
              </Button>
            </Box>
          </form>
        </Container>
      </CardContent>
    </Card>
  );
}

export default DocumentosToPdf;