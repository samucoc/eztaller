import React, { useState } from 'react';
import {  TextField, Button, Grid, Card, CardContent, Typography, RadioGroup, FormControlLabel, Radio, 
         FormControl, InputLabel, Select, MenuItem } from '@mui/material';
import '../../css/Empresas.css';

const EmpresaForm = ({ onSubmit, onCancel, initialEmpresa, comunas }) => {
  const [empresaData, setEmpresaData] = useState({
    rut: initialEmpresa ? initialEmpresa.rut : '',
    dv: initialEmpresa ? initialEmpresa.dv : '',
    RazonSocial: initialEmpresa ? initialEmpresa.RazonSocial : '',
    NombreFantasia: initialEmpresa ? initialEmpresa.NombreFantasia : '',
    direccion: initialEmpresa ? initialEmpresa.direccion : '',
    comuna_id: initialEmpresa ? initialEmpresa.comuna_id : '',
    contactoRRHH: initialEmpresa ? initialEmpresa.contactoRRHH : '',
    telefonoConcacto: initialEmpresa ? initialEmpresa.telefonoConcacto : '',
    correoContacto: initialEmpresa ? initialEmpresa.correoContacto : '',
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(empresaData);
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setEmpresaData({ ...empresaData, [name]: value });
  };

  return (
    <Card sx={{ maxWidth: 600, margin: 'auto', padding: 2 }}>
    <CardContent>
      <Typography variant="h5" gutterBottom>
        Crear Empresa
      </Typography>
      <form onSubmit={handleSubmit}>
        <Grid container spacing={2}>
          <Grid item xs={12}>
            <TextField
              variant="outlined"
              required
              fullWidth
              id="RazonSocial"
              label="Razón Social"
              name="RazonSocial"
              value={empresaData.RazonSocial}
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
            <TextField
              variant="outlined"
              required
              fullWidth
              id="NombreFantasia"
              label="Nombre Fantasia"
              name="NombreFantasia"
              value={empresaData.NombreFantasia}
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
          <Grid item xs={6}>
            <TextField
              variant="outlined"
              required
              fullWidth
              id="rut"
              label="Rut"
              name="rut"
              value={empresaData.rut}
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
          <Grid item xs={6}>
            <TextField
              variant="outlined"
              required
              fullWidth
              id="dv"
              label="Dígito Verificador"
              name="dv"
              value={empresaData.dv}
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
            <TextField
              variant="outlined"
              required
              fullWidth
              id="direccion"
              label="Dirección"
              name="direccion"
              value={empresaData.direccion}
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
            <TextField
              variant="outlined"
              required
              fullWidth
              select
              id="comuna_id"
              label="Comuna"
              name="comuna_id"
              value={empresaData.comuna_id}
              onChange={handleChange}
              sx={{ color: 'black' }}
              InputLabelProps={{ 
                style: { color: 'black' }  // Set label color
              }}
              InputProps={{ 
                style: { color: 'black' }  // Set input text color
              }}
            >
              {comunas.map((comuna) => (
                <MenuItem key={comuna.id} value={comuna.id}>
                  {comuna.nombre}
                </MenuItem>
              ))}
            </TextField>
          </Grid>
          <Grid item xs={12}>
            <TextField
              variant="outlined"
              required
              fullWidth
              id="contactoRRHH"
              label="Responsable"
              name="contactoRRHH"
              value={empresaData.contactoRRHH}
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
            <TextField
              variant="outlined"
              required
              fullWidth
              id="correoContacto"
              label="Email"
              name="correoContacto"
              value={empresaData.correoContacto}
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
            <TextField
              variant="outlined"
              required
              fullWidth
              id="telefonoConcacto"
              label="Contacto Telefónico"
              name="telefonoConcacto"
              value={empresaData.telefonoConcacto}
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
          <Grid item xs={6}>
            <Button
              type="submit"
              fullWidth
              variant="contained"
              className="crear-empresa-btn" 
              >
              Crear Empresa
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
        </Grid>
      </form>
    </CardContent>
  </Card>

  );
};

export default EmpresaForm;
