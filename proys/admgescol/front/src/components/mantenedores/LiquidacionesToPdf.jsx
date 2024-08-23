// components/LiquidacionesToPdf.jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../../css/LiquidacionesToPdf.css';
import API_BASE_URL from '../config/apiConstants';
import {
  Container,
  Typography,
  FormControl,
  InputLabel,
  Select,
  MenuItem,
  Button,
  CircularProgress,
  TextField,
  Box
} from '@mui/material';
import swal from 'sweetalert2';
import Loader from 'react-loader-spinner';
import { useSelector } from 'react-redux'; // Importar useSelector

const LiquidacionesToPdf = () => {
  const [empresa_id, setEmpresa_Id] = useState('');
  const [month, setMonth] = useState('');
  const [year, setYear] = useState('');
  const [file, setFile] = useState(null);
  const [loading, setLoading] = useState(false);
  const [empresas, setEmpresas] = useState([]);
  const empresaIdS = useSelector((state) => state.empresaId); // Obtener empresaId de Redux

  const fetchEmpresas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/empresas`);
      setEmpresas(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de empresas:', error);
    }
  };

  useEffect(() => {
    fetchEmpresas();
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

  const handleSubmit = async (event) => {
    event.preventDefault();

    if (!month || !year || !file) {
      alert('Por favor, complete todos los campos.');
      return;
    }

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

    try {
      const formData = new FormData();
      formData.append('file', file);
      formData.append('output_type', 'PDF/A-1b');
      formData.append('rasterize_if_errors_encountered', 'on');

      const config = {
        method: 'post',
        url: 'https://api.pdfrest.com/pdfa',
        headers: {
          'Api-Key': 'b026d6e6-529b-4f34-9e04-71d4303186d4',
          'Content-Type': 'multipart/form-data',
        },
        data: formData,
      };

      const pdfRestResponse = await axios(config);

      const convertedPdfUrl = pdfRestResponse.data.outputUrl;

      // Obtener el archivo convertido desde la URL
      const convertedFileResponse = await axios.get(convertedPdfUrl, {
        responseType: 'blob',
      });

      const convertedFile = new File([convertedFileResponse.data], 'converted.pdf', {
        type: 'application/pdf',
      });

      // Preparar el FormData con el archivo convertido
      const uploadFormData = new FormData();
      uploadFormData.append('empresa_id', empresa_id);
      uploadFormData.append('month', month);
      uploadFormData.append('year', year);
      uploadFormData.append('file', convertedFile);

      // Enviar el formulario al servidor usando axios
      try {
        const response = await axios.post(`${API_BASE_URL}/documentos/upload`, uploadFormData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        console.log('Respuesta del servidor:', response.data);
        swal.fire('Correcto', response.data.message, 'success');
      } catch (error) {
        console.error('Error al enviar los datos:', error);
        swal.fire('Error', 'Error al enviar los datos.', 'error');
      } finally {
        setLoading(false);
      }
    } catch (error) {
      console.error('Error al convertir el archivo a PDF/A:', error);
      swal.fire('Error', 'Error al convertir el archivo a PDF/A.', 'error');
      setLoading(false);
    }
  };
  
  return (
<Container className="liquidaciones-to-pdf" maxWidth="sm">
      <Typography variant="h4" component="h2" gutterBottom>
        Ingresar Liquidaciones
      </Typography>
      <form onSubmit={handleSubmit}>
        {empresaIdS ? (
          <TextField
            variant="outlined"
            fullWidth
            id="empresa_id"
            name="empresa_id"
            type="hidden"
            value={empresa_id}
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
            <InputLabel id="month-label">Mes</InputLabel>
            <Select
              labelId="month-label"
              id="month"
              value={month}
              onChange={handleMonthChange}
              label="Mes"
              sx={{
                color: 'black', // Explicitly set text color to black
                '& .MuiSelect-select': {
                  color: 'black', // Set selected text color to black
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
        </Box>
        <Box mb={3}>
          <FormControl fullWidth variant="outlined" margin="normal">
            <InputLabel id="year-label">Año</InputLabel>
            <Select
              labelId="year-label"
              id="year"
              value={year}
              onChange={handleYearChange}
              label="Año"
              sx={{
                color: 'black', // Explicitly set text color to black
                '& .MuiSelect-select': {
                  color: 'black', // Set selected text color to black
                },
              }}

            >
              <MenuItem value="">
                <em>Seleccionar año...</em>
              </MenuItem>
              <MenuItem value="2022">2022</MenuItem>
              <MenuItem value="2023">2023</MenuItem>
              <MenuItem value="2024">2024</MenuItem>
            </Select>
          </FormControl>
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
  
  );
}

export default LiquidacionesToPdf;