import React, { useState } from 'react';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import MenuItem from '@material-ui/core/MenuItem'; // Importa MenuItem desde Material-UI

const EmpresaForm = ({ onSubmit, onCancel, initialEmpresa, comunas }) => {
  const [empresaData, setEmpresaData] = useState({
    rut: initialEmpresa ? initialEmpresa.rut : '',
    dv: initialEmpresa ? initialEmpresa.dv : '',
    RazonSocial: initialEmpresa ? initialEmpresa.RazonSocial : '',
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
    <form onSubmit={handleSubmit}>
      <Grid container spacing={2}>
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
          />
        </Grid>
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
            label="Contacto RRHH"
            name="contactoRRHH"
            value={empresaData.contactoRRHH}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12}>
          <TextField
            variant="outlined"
            required
            fullWidth
            id="telefonoConcacto"
            label="Teléfono de Contacto"
            name="telefonoConcacto"
            value={empresaData.telefonoConcacto}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12}>
          <TextField
            variant="outlined"
            required
            fullWidth
            id="correoContacto"
            label="Correo de Contacto"
            name="correoContacto"
            value={empresaData.correoContacto}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12}>
          <Button
            type="submit"
            fullWidth
            variant="contained"
            color="primary"
          >
            Guardar
          </Button>
        </Grid>
        <Grid item xs={12}>
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
            onClick={onCancel} // Cambiar esto a la función para volver a la lista de Empresas
          >
            Volver a la lista de Empresas
          </Button>
        </Grid>
      </Grid>
    </form>
  );
};

export default EmpresaForm;
