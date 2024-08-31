import React, { useState } from 'react';
import { useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';
import axios from 'axios'; // Importa axios
import API_BASE_URL from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import { Card, CardContent, Typography, RadioGroup, FormControlLabel, Radio, TextField, Button, Grid, FormControl, InputLabel, Select, MenuItem } from '@mui/material';


import Swal from 'sweetalert2';

const SolicitudesVac = ({ onSubmit, onCancel }) => {
  const navigate = useNavigate();
  const [fechaInicio, setFechaInicio] = useState('');
  const [fechaFin, setFechaFin] = useState('');
  const [comentario, setComentario] = useState('');

  // Obtener el DNI del usuario desde Redux para usar como 'trabajador'
  const trabajador = useSelector((state) => state.userDNI);
  const empresaId = useSelector((state) => state.empresaId); // Assuming empresaId is stored in Redux

  // Obtener la fecha actual en formato YYYY-MM-DD para 'fecha'
  const fecha = new Date().toISOString().split('T')[0];

  const handleCancel = () =>{
    navigate('/UserDashboard')
  }
  
  const handleSubmit = async (e) => {
    e.preventDefault();

    const vacacionesData = {
      tipo_sol_id: 4, // Suponiendo que el tipo_sol_id para vacaciones es 3
      empresa_id: empresaId,  // Fixed value for tipo_sol_id
      trabajador: trabajador, // User DNI desde Redux
      fecha: fecha, // Fecha actual
      fecha_inicio: fechaInicio,
      fecha_fin: fechaFin,
      comentario: comentario,
      status: 1, // Valor fijo para status
    };

    try {
      const response = await axios.post(API_BASE_URL+'/solicitudes', vacacionesData);
      console.log('Solicitud de vacaciones enviada:', response.data);
      // Aquí puedes manejar la respuesta, como mostrar una notificación de éxito

      // Mostrar notificación de éxito usando SweetAlert2
      Swal.fire({
          icon: 'success',
          title: 'Solicitud enviada',
          text: 'Tu solicitud de vacaciones ha sido enviada con éxito.',
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
          text: 'Hubo un problema al enviar tu solicitud de vacaciones. Por favor, intenta nuevamente.',
          confirmButtonText: 'OK',
      });
      navigate('/UserDashboard')
    }  };

  return (
    <Card sx={{ maxWidth: 600, margin: 'auto', padding: 2 }}>
    <CardContent>
      <Typography variant="h5" gutterBottom>
        Solicitud de Vacaciones
      </Typography>
      <form onSubmit={handleSubmit}>
        <Grid container spacing={2} alignItems="center" sx={{ color: 'black' }}>
          <Grid item xs={6}>
            <TextField
              variant="outlined"
              required
              fullWidth
              id="fechaInicio"
              label="Fecha de Inicio"
              name="fechaInicio"
              type="date"
              InputLabelProps={{ shrink: true }}
              value={fechaInicio}
              onChange={(e) => setFechaInicio(e.target.value)}
            />
          </Grid>
          <Grid item xs={6}>
            <TextField
              variant="outlined"
              required
              fullWidth
              id="fechaFin"
              label="Fecha de Término"
              name="fechaFin"
              type="date"
              InputLabelProps={{ shrink: true }}
              value={fechaFin}
              onChange={(e) => setFechaFin(e.target.value)}
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
              variant="outlined"               onClick={handleCancel}
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

export default SolicitudesVac;
