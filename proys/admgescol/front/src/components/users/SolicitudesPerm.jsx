import React, { useState } from 'react';
import { useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';
import axios from 'axios'; // Importa axios
import API_BASE_URL from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import { Card, CardContent, Typography, RadioGroup, FormControlLabel, Radio, TextField, Button, Grid, FormControl, InputLabel, Select, MenuItem } from '@mui/material';
import Swal from 'sweetalert2';

const SolicitudesPerm = () => {
  const [selectedOption, setSelectedOption] = useState('');
  const [formData, setFormData] = useState({
    fecha: '',
    horas: '',
    time: '',
    goce: '',
    motivo: '',
    fecha_fin: ''
  });
  const navigate = useNavigate();

  // Obtener el DNI del usuario desde Redux para usar como 'trabajador'
  const trabajador = useSelector((state) => state.userDNI);
  const empresaId = useSelector((state) => state.empresaId); // Assuming empresaId is stored in Redux

  const handleOptionChange = (event) => {
    setSelectedOption(event.target.value);
    setFormData({ ...formData, fecha: '', horas: '', time: '', goce: '', motivo: '', fecha_fin: '' }); // Reset form data on option change
  };

  const handleChange = (event) => {
    setFormData({ ...formData, [event.target.name]: event.target.value });
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    
    const vacacionesData = {
      tipo_sol_id: 3, // Suponiendo que el tipo_sol_id para vacaciones es 3
      empresa_id: empresaId,  // Fixed value for tipo_sol_id
      trabajador: trabajador, // User DNI desde Redux
      fecha: formData.fecha, // Fecha actual
      fecha_fin: formData.fecha_fin,
      comentario: formData.motivo,
      horas: formData.horas,
      time: formData.time,
      goce: formData.goce,
      status: 1, // Valor fijo para status
    };

    try {
      const response = await axios.post(API_BASE_URL+'/solicitudes', vacacionesData);
      console.log('Solicitud de permiso enviada:', response.data);
      // Aquí puedes manejar la respuesta, como mostrar una notificación de éxito

      // Mostrar notificación de éxito usando SweetAlert2
      Swal.fire({
          icon: 'success',
          title: 'Solicitud enviada',
          text: 'Tu solicitud de permiso ha sido enviado con éxito.',
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
          text: 'Hubo un problema al enviar tu solicitud de permiso. Por favor, intenta nuevamente.',
          confirmButtonText: 'OK',
      });
      navigate('/UserDashboard')
    }  };

  const renderForm = () => {
    switch (selectedOption) {
      case 'algunasHoras':
        return (
          <Grid container spacing={2} alignItems="center" sx={{ color: 'black' }}>
            <Grid item xs={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                name="fecha"
                label="Fecha"
                type="date"
                InputLabelProps={{ shrink: true }}
                value={formData.fecha}
                onChange={handleChange}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  shrink: true,
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
                name="horas"
                label="Cantidad de Horas"
                type="number"
                value={formData.horas}
                onChange={handleChange}
                inputProps={{ min: 0 }}
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
                name="time"
                label="Hora de Inicio"
                type="time"
                InputLabelProps={{ shrink: true }}
                value={formData.time}
                onChange={handleChange}
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
              <FormControl fullWidth>
                <InputLabel>Con o sin goce de sueldo</InputLabel>
                <Select
                  name="goce"
                  value={formData.goce}
                  onChange={handleChange}
                  sx={{ color: 'black' }}
                  InputProps={{ 
                    style: { color: 'black' }  // Set input text color
                  }}
                  >
                  <MenuItem value="0">Con goce de sueldo</MenuItem>
                  <MenuItem value="1">Sin goce de sueldo</MenuItem>
                </Select>
              </FormControl>
            </Grid>
            <Grid item xs={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                name="motivo"
                label="Motivo"
                multiline
                rows={4}
                value={formData.motivo}
                onChange={handleChange}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  style: { color: 'black' }  // Set label color
                }}
                InputProps={{ 
                  style: { color: 'black' }  // Set input text color
                }}
              />
            </Grid>
          </Grid>
        );
      case 'todoElDia':
        return (
          <Grid container spacing={2} alignItems="center" sx={{ color: 'black' }}>
            <Grid item xs={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                name="fecha"
                label="Fecha"
                type="date"
                InputLabelProps={{ shrink: true }}
                value={formData.fecha}
                onChange={handleChange}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  shrink: true,
                  style: { color: 'black' }  // Set label color
                }}
                InputProps={{ 
                  style: { color: 'black' }  // Set input text color
                }}
              />
            </Grid>
            <Grid item xs={12}>
              <FormControl fullWidth>
                <InputLabel>Con o sin goce de sueldo</InputLabel>
                <Select
                  name="goce"
                  value={formData.goce}
                  onChange={handleChange}
                  sx={{ color: 'black' }}
                  InputProps={{ 
                    style: { color: 'black' }  // Set input text color
                  }}
                  >
                  <MenuItem value="0">Con goce de sueldo</MenuItem>
                  <MenuItem value="1">Sin goce de sueldo</MenuItem>
                </Select>
              </FormControl>
            </Grid>
            <Grid item xs={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                name="motivo"
                label="Motivo"
                multiline
                rows={4}
                value={formData.motivo}
                onChange={handleChange}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  style: { color: 'black' }  // Set label color
                }}
                InputProps={{ 
                  style: { color: 'black' }  // Set input text color
                }}
              />
            </Grid>
          </Grid>
        );
      case 'variosDias':
        return (
          <Grid container spacing={2} alignItems="center" sx={{ color: 'black' }}>
            <Grid item xs={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                name="desde"
                label="Desde"
                type="date"
                InputLabelProps={{ shrink: true }}
                value={formData.desde}
                onChange={handleChange}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  shrink: true,
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
                name="fecha_fin"
                label="fecha_fin"
                type="date"
                InputLabelProps={{ shrink: true }}
                value={formData.fecha_fin}
                onChange={handleChange}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  shrink: true,
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
                name="horas"
                label="Cantidad de Horas"
                type="number"
                value={formData.horas}
                onChange={handleChange}
                inputProps={{ min: 0 }}
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
                name="time"
                label="Hora de Inicio"
                type="time"
                InputLabelProps={{ shrink: true }}
                value={formData.time}
                onChange={handleChange}
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
              <FormControl fullWidth>
                <InputLabel>Con o sin goce de sueldo</InputLabel>
                <Select
                  name="goce"
                  value={formData.goce}
                  onChange={handleChange}
                  sx={{ color: 'black' }}
                  InputProps={{ 
                    style: { color: 'black' }  // Set input text color
                  }}
                  >
                  <MenuItem value="0">Con goce de sueldo</MenuItem>
                  <MenuItem value="1">Sin goce de sueldo</MenuItem>
                </Select>
              </FormControl>
            </Grid>
            <Grid item xs={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                name="motivo"
                label="Motivo"
                multiline
                rows={4}
                value={formData.motivo}
                onChange={handleChange}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  style: { color: 'black' }  // Set label color
                }}
                InputProps={{ 
                  style: { color: 'black' }  // Set input text color
                }}
              />
            </Grid>
          </Grid>
        );
      default:
        return null;
    }
  };

  return (
<Card sx={{ maxWidth: 600, margin: 'auto', padding: 2 }}>
  <CardContent>
    <Typography variant="h5" gutterBottom>
      Solicitud de Permiso
    </Typography>
    <RadioGroup value={selectedOption} onChange={handleOptionChange}>
      <FormControlLabel value="algunasHoras" control={<Radio />} label="Algunas horas" />
      <FormControlLabel value="todoElDia" control={<Radio />} label="Todo el día" />
      <FormControlLabel value="variosDias" control={<Radio />} label="Varios días" />
    </RadioGroup>
    <hr></hr>
    <form 
      onSubmit={handleSubmit} 
      sx={{ color: 'black', marginBottom: 4 }} // Add marginBottom to create space
    >
      {renderForm()}
      <Grid container spacing={2} sx={{ mt: 2 }}>
        <Grid item xs={6}>
          <Button type="submit" fullWidth variant="contained" color="primary">
            Enviar Solicitud
          </Button>
        </Grid>
        <Grid item xs={6}>
          <Button fullWidth variant="outlined" onClick={() => setSelectedOption('')}>
            Cancelar
          </Button>
        </Grid>
      </Grid>
    </form>
  </CardContent>
</Card>
  );
};

export default SolicitudesPerm;
