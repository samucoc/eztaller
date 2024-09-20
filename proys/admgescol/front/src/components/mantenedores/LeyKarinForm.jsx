import React, { useState } from 'react';
import { Link, Grid, Typography, Button, Divider, Box } from '@mui/material';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants';

const DenunciaForm = ({ onSubmit, onCancel, initialDenuncia }) => {
  const [nombre, setNombre] = useState(initialDenuncia ? initialDenuncia.denuncianteNombre : '');
  const [apellidos, setApellidos] = useState(initialDenuncia ? initialDenuncia.denuncianteApellidos : '');
  const [rut, setRut] = useState(initialDenuncia ? initialDenuncia.denuncianteRut : '');
  const [celular, setCelular] = useState(initialDenuncia ? initialDenuncia.denuncianteCelular : '');
  const [email, setEmail] = useState(initialDenuncia ? initialDenuncia.denuncianteEmail : '');
  const [relacionTrabajo, setRelacionTrabajo] = useState(initialDenuncia ? initialDenuncia.denuncianteRelacionTrabajo : '');
  const [implicados, setImplicados] = useState(initialDenuncia ? initialDenuncia.implicados : []);
  const [adjuntos, setAdjuntos] = useState(initialDenuncia ? initialDenuncia.adjuntos : []);

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit({
      nombre,
      apellidos,
      rut,
      celular,
      email,
      relacion_trabajo: relacionTrabajo,
      implicados,
      adjuntos,
    });
  };

  return (
    <form onSubmit={handleSubmit}>
      <Typography variant="h5" component="h3" gutterBottom>
        Denuncia Nro. {initialDenuncia.id}
      </Typography>
      
      <Divider />
      
      <Box mt={2} mb={2}>
        <Typography variant="h6" component="h5" gutterBottom>
          1. Datos del Denunciante
        </Typography>
        <Typography variant="body1" component="p">- Nombre: {apellidos}, {nombre}</Typography>
        <Typography variant="body1" component="p">- Rut: {rut}</Typography>
        <Typography variant="body1" component="p">- Teléfono: {celular}</Typography>
        <Typography variant="body1" component="p">- Email: {email}</Typography>
        <Typography variant="body1" component="p">- Relación con la empresa: {relacionTrabajo}</Typography>
      </Box>
      
      <Divider />
      
      <Box mt={2} mb={2}>
        <Typography variant="h6" component="h5" gutterBottom>
          2. Datos de Implicados
        </Typography>
        {implicados.map((implicado, index) => (
          <Box mb={2} key={index}>
            <Typography variant="body1" component="p">- Nombre: {implicado.apellidos}, {implicado.nombre}</Typography>
            <Typography variant="body1" component="p">- Lugar: {implicado.lugar}</Typography>
            <Typography variant="body1" component="p">- Cargo: {implicado.cargo}</Typography>
            <Typography variant="body1" component="p">- Descripción de los hechos</Typography>
            <Typography variant="body2" component="p" dangerouslySetInnerHTML={{ __html: implicado.denuncia }} />
          </Box>
        ))}
      </Box>

      <Divider />

      <Box mt={2} mb={2}>
        <Typography variant="h6" component="h6" gutterBottom>
          3. Evidencias Adjuntas
        </Typography>
        {adjuntos.map((adjunto, index) => (
          <Box mb={2} key={index}>
            <Typography variant="body1" component="p">
              - {adjunto.nombre || ''} 
              <Button
                href={`${API_DOWNLOAD_URL}/${adjunto.ruta || '#'}`}
                target="_blank"
                rel="noopener noreferrer"
                variant="outlined"
                color="primary"
                size="small"
                style={{ marginLeft: '1rem' }}
              >
                Ver Archivo
              </Button>
            </Typography>
          </Box>
        ))}
      </Box>

      <Grid container spacing={2}>
        <Grid item xs={12}>
          <Button
            fullWidth
            variant="outlined"
            onClick={onCancel}
          >
            Volver a Denuncias
          </Button>
        </Grid>
      </Grid>
    </form>
  );
};

export default DenunciaForm;