import React, { useState } from 'react';
import { useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';
import axios from 'axios'; // Importa axios
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import { Card, CardContent, Typography, RadioGroup, FormControlLabel, Radio, TextField, Button, Grid, FormControl, InputLabel, Select, MenuItem } from '@mui/material';
import Swal from 'sweetalert2';

const SolicitudesAnti = ({ onSubmit, onCancel }) => {
  const [monto, setMonto] = useState('');
  const [comentario, setComentario] = useState('');
  const navigate = useNavigate();

  // Fetch userDNI from Redux store to use as 'trabajador'
  const trabajador = useSelector((state) => state.userDNI);
  const empresaId = useSelector((state) => state.empresaId); // Assuming empresaId is stored in Redux

  // Get the current date in YYYY-MM-DD format for 'fecha'
  const fecha = new Date().toISOString().split('T')[0];

  const handleCancel = () =>{
    navigate('/UserDashboard')
  }
  
  const handleSubmit = async (e) => {
    e.preventDefault();
    
    const anticipoData = {
      tipo_sol_id: 1,  // Fixed value for tipo_sol_id
      empresa_id: empresaId,  // Fixed value for tipo_sol_id
      trabajador: trabajador,  // User DNI from Redux
      fecha: fecha,  // Current date
      monto: monto,
      cuotas: 1,  // Fixed value for cuotas
      comentario: comentario,
      status: 1,  // Fixed value for status
    };

    try {
        const response = await axios.post(API_BASE_URL+'/solicitudes', anticipoData);
        console.log('Solicitud de anticipo enviada:', response.data);
        // Aquí puedes manejar la respuesta, como mostrar una notificación de éxito

        // Mostrar notificación de éxito usando SweetAlert2
        Swal.fire({
            icon: 'success',
            title: 'Solicitud enviada',
            text: 'Tu solicitud de anticipo ha sido enviada con éxito.',
            confirmButtonText: 'OK',
        });
        navigate('/UserDashboard')
      } catch (error) {
        console.error('Error al enviar la solicitud de vacaciones:', error);
        // Aquí puedes manejar el error, como mostrar una notificación de error

        // Mostrar notificación de error usando SweetAlert2
        Swal.fire({
            icon: 'error',
            title: 'Error al enviar solicitud',
            text: 'Hubo un problema al enviar tu solicitud de anticipo. Por favor, intenta nuevamente.',
            confirmButtonText: 'OK',
        });
        navigate('/UserDashboard')
      }
  };

  return (
    <Card sx={{ maxWidth: 600, margin: 'auto', padding: 2 }}>
      <CardContent>
        <Typography variant="h5" gutterBottom>
          Solicitud de Anticipo
        </Typography>
        <form onSubmit={handleSubmit}>
          <Grid container spacing={2} alignItems="center">
            <Grid item xs={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                id="monto"
                label="Monto"
                type="number" // Asegura que el campo acepte solo números
                name="monto"
                value={monto}
                onChange={(e) => setMonto(e.target.value)}
                inputProps={{ min: 0 }} // Puedes establecer valores mínimos si es necesario
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  style: { color: 'black' }  // Set label color
                }}
                InputProps={{ 
                  style: { color: 'black' }  // Set input text color
                }}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                id="comentario"
                label="Comentario"
                name="comentario"
                multiline
                rows={4}
                value={comentario}
                onChange={(e) => setComentario(e.target.value)}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  style: { color: 'black' }  // Set label color
                }}
                InputProps={{ 
                  style: { color: 'black' }  // Set input text color
                }}
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
                variant="outlined"                 onClick={handleCancel}
              >
                Cancelar
              </Button>
            </Grid>
          </Grid>
        </form>
      </CardContent>
    </Card>
  );
};

export default SolicitudesAnti;
