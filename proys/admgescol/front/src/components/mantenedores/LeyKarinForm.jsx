import React, { useState } from 'react';
import { Link, Grid, Typography, Button, Divider, Card, CardContent, Box } from '@mui/material';
import { API_DOWNLOAD_URL } from '../config/apiConstants';
import VisibilityIcon from '@mui/icons-material/Visibility';
import html2pdf from 'html2pdf.js';
import '../../css/LeyKarin.css';

const DenunciaForm = ({ onSubmit, onCancel, initialDenuncia }) => {
  const [nombre, setNombre] = useState(initialDenuncia ? initialDenuncia.denuncianteNombre : '');
  const [apellidos, setApellidos] = useState(initialDenuncia ? initialDenuncia.denuncianteApellidos : '');
  const [rut, setRut] = useState(initialDenuncia ? initialDenuncia.denuncianteRut : '');
  const [celular, setCelular] = useState(initialDenuncia ? initialDenuncia.denuncianteCelular : '');
  const [email, setEmail] = useState(initialDenuncia ? initialDenuncia.denuncianteEmail : '');
  const [relacionTrabajo, setRelacionTrabajo] = useState(initialDenuncia ? initialDenuncia.denuncianteRelacionTrabajo : '');
  const [implicados, setImplicados] = useState(initialDenuncia ? initialDenuncia.implicados : []);
  const [adjuntos, setAdjuntos] = useState(initialDenuncia ? initialDenuncia.adjuntos : []);
  const [denuncia, setDenuncia] = useState(initialDenuncia ? initialDenuncia.denuncia : []);

  const handleGeneratePDF = () => {
    const element = document.getElementById('denuncia-form');
    
    // Options for better styling preservation
    const options = {
      filename: `denuncia_${initialDenuncia.id}.pdf`,
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2 },  // Improves resolution
      jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Generate PDF
    html2pdf().set(options).from(element).save();
  };

  return (
    <form id="denuncia-form">
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 2 }}>
        <Typography variant="h5" component="h3" gutterBottom>
          Denuncia Nro. {initialDenuncia.id}
        </Typography>

        <Button
          variant="outlined"
          color="primary"
          onClick={handleGeneratePDF}
          className="no-print"
        >
          Generar PDF
        </Button>
      </Box>

      <Divider />

      <Card sx={{ mt: 2, mb: 2, backgroundColor: '#f5f5f5' }}>
        <CardContent>
          <Typography variant="h6" component="h5" gutterBottom>
            Datos del Denunciante
          </Typography>
          <Typography variant="body1" component="p">- Nombre: {apellidos}, {nombre}</Typography>
          <Typography variant="body1" component="p">- Rut: {rut}</Typography>
          <Typography variant="body1" component="p">- Teléfono: {celular}</Typography>
          <Typography variant="body1" component="p">- Email: {email}</Typography>
          <Typography variant="body1" component="p">- Relación con la empresa: {relacionTrabajo}</Typography>
        </CardContent>
      </Card>

      <Divider />

      <Card sx={{ mt: 2, mb: 2, backgroundColor: '#f5f5f5' }}>
        <CardContent>
          <Typography variant="h6" component="h5" gutterBottom>
            Datos de Implicados
          </Typography>
          {implicados.map((implicado, index) => (
            <Card key={index} sx={{ mb: 2, backgroundColor: '#f5f5f5' }}>
              <CardContent>
                <Typography variant="h8" component="h7" gutterBottom>
                  Denunciante nro. {index + 1}
                </Typography>
                <br></br>
                <Typography variant="body1" component="p">- Nombre: {implicado.apellidos}, {implicado.nombre}</Typography>
                <Typography variant="body1" component="p">- Lugar: {implicado.lugar}</Typography>
                <Typography variant="body1" component="p">- Cargo: {implicado.cargo}</Typography>
              </CardContent>
            </Card>
          ))}
        </CardContent>
      </Card>

      <Divider />

      <Card sx={{ mt: 2, mb: 2, backgroundColor: '#f5f5f5' }}>
        <CardContent>
          <Typography variant="h6" component="h5" gutterBottom>
            Descripción de los hechos
          </Typography>
          <Card sx={{ mb: 2, backgroundColor: '#f5f5f5' }}>
            <CardContent>
              <Typography variant="body2" component="p" dangerouslySetInnerHTML={{ __html: denuncia }} />
            </CardContent>
          </Card>
        </CardContent>
      </Card>

      <Divider />

      {/* Excluding the attachments section from the PDF */}
      <Card sx={{ mt: 2, mb: 2, backgroundColor: '#f5f5f5' }} className="no-print">
        <CardContent>
          <Typography variant="h6" component="h6" gutterBottom>
            Evidencias Adjuntas
          </Typography>
          {adjuntos.map((adjunto, index) => (
            <Card key={index} sx={{ mb: 2, backgroundColor: '#fafafa', borderRadius: '8px', boxShadow: 1 }}>
              <CardContent sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <Typography variant="body1" component="p" sx={{ color: '#333' }}>
                  - {adjunto.nombre || 'Sin nombre'}
                </Typography>
                <Button
                  href={`${API_DOWNLOAD_URL}/${adjunto.ruta || '#'}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  variant="outlined"
                  color="primary"
                  size="small"
                  startIcon={<VisibilityIcon />}
                  sx={{ ml: 2 }}
                >
                  Ver Archivo
                </Button>
              </CardContent>
            </Card>
          ))}
        </CardContent>
      </Card>

      <Grid container spacing={2} className="no-print"> 
        <Grid item xs={12}>
          <Button fullWidth variant="outlined" onClick={onCancel}>
            Volver a Denuncias
          </Button>
        </Grid>


      </Grid>
    </form>
  );
};

export default DenunciaForm;
