import React, { useState, useEffect } from 'react';
import { Button, TextField, Grid } from '@material-ui/core';
import { useSelector } from 'react-redux';

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
          <TextField
            variant="outlined"
            required
            fullWidth
            id="descripcion"
            label="Descripción"
            name="descripcion"
            multiline
            rows={4}
            value={descripcion}
            onChange={(e) => setDescripcion(e.target.value)}
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
      </Grid>
    </form>
  );
};

export default ComunicacionesForm;
