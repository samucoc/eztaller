import React, { useState } from 'react';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';

const SexoForm = ({ onSubmit, onCancel, initialSexo }) => {
  const [nombre, setNombre] = useState(initialSexo ? initialSexo.nombre : '');

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit({ nombre });
  };

  return (
    <form onSubmit={handleSubmit}>
      <Grid container spacing={2} alignItems="center">
        <Grid item xs={12}>
          <TextField
            variant="outlined"
            required
            fullWidth
            id="nombre"
            label="Nombre"
            name="nombre"
            value={nombre}
            onChange={(e) => setNombre(e.target.value)}
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
        <Grid item xs={12}>
          <Button
            fullWidth
            variant="outlined"
            onClick={onCancel} // Cambiar esto a la función para volver a la lista de Sexos
          >
            Volver a la lista de Sexos
          </Button>
        </Grid>
      </Grid>
    </form>
  );
};

export default SexoForm;
