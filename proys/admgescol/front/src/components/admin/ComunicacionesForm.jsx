import React, { useState, useEffect } from 'react';
import { Button, TextField, Grid, Card, CardContent, Typography } from '@material-ui/core';
import { useSelector } from 'react-redux';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css'; // Importa los estilos de Quill
import '../../css/Empresas.css';

const ComunicacionesForm = ({ onSubmit, onCancel, initialComunicacion }) => {
  const [titulo, setTitulo] = useState(initialComunicacion ? initialComunicacion.titulo : '');
  const [descripcion, setDescripcion] = useState(initialComunicacion ? initialComunicacion.descripcion : '');
  const userID = useSelector((state) => state.userDNI); // Get userID from Redux
  const empresaId = useSelector((state) => state.empresaId); // Assuming userID is stored in Redux

  const handleSubmit = (e) => {
    e.preventDefault();
    const fechahora = new Date().toISOString(); // Current date and time
    onSubmit({ user_id: userID, empresa_id: empresaId, titulo, descripcion, fechahora });
  };

  useEffect(() => {
    if (initialComunicacion) {
      setTitulo(initialComunicacion.titulo);
      setDescripcion(initialComunicacion.descripcion);
    }
  }, [initialComunicacion]);

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
                id="titulo"
                label="Título"
                name="titulo"
                value={titulo}
                onChange={(e) => setTitulo(e.target.value)}
              />
            </Grid>
            <Grid item xs={12}>
              <ReactQuill 
                  theme="snow" 
                  value={descripcion} 
                  onChange={setDescripcion} 
                  placeholder="Escribe la descripción aquí..." 
                />
            </Grid>
            <Grid item xs={6}>
              <Button
                type="submit"
                fullWidth
                variant="contained"
                className="crear-empresa-btn" 
                >
                Guardar
              </Button>
            </Grid>
            <Grid item xs={6}>
              <Button
                fullWidth
                variant="outlined"
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

export default ComunicacionesForm;
