import React, { useState } from 'react';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';

const CargoForm = ({ onSubmit, onCancel, initialCargo }) => {
  const [nombre, setNombre] = useState(initialCargo ? initialCargo.nombre : '');

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
            onClick={onCancel} // Cambiar esto a la función para volver a la lista de Cargos
          >
            Volver a la lista de Cargos
          </Button>
        </Grid>
      </Grid>
    </form>
  );
};

export default CargoForm;
