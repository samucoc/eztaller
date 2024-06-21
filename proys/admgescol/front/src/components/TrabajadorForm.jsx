import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import MenuItem from '@material-ui/core/MenuItem';
import API_BASE_URL from './apiConstants'; 
import IconButton from '@mui/material/IconButton';
import PhotoLibraryOutlinedIcon from '@mui/icons-material/PhotoLibraryOutlined';
import { useTheme } from '@mui/material/styles';

const TrabajadorForm = ({ onSubmit, onCancel, initialTrabajador, empresaId }) => {
  const [formData, setFormData] = useState({
    empresa_id: initialTrabajador ? initialTrabajador.empresa_id :'',
    user_id: initialTrabajador ? initialTrabajador.user_id :'',
    rut: initialTrabajador ? initialTrabajador.rut : '',
    dv: initialTrabajador ? initialTrabajador.dv : '',
    apellido_paterno: initialTrabajador ? initialTrabajador.apellido_paterno : '',
    apellido_materno: initialTrabajador ? initialTrabajador.apellido_materno : '',
    nombres: initialTrabajador ? initialTrabajador.nombres : '',
    nombre_social: initialTrabajador ? initialTrabajador.nombre_social : '',
    fecha_nac: initialTrabajador ? initialTrabajador.fecha_nac : new Date(), 
    nacionalidad: initialTrabajador ? initialTrabajador.nacionalidad : '',
    cargo_id: initialTrabajador ? initialTrabajador.cargo_id :'',
    sexo_id: initialTrabajador ? initialTrabajador.sexo_id :'',
    foto: initialTrabajador ? initialTrabajador.foto : '',
    direccion: initialTrabajador ? initialTrabajador.direccion : '',
    comuna_id: initialTrabajador ? initialTrabajador.comuna_id :'',
    telefono: initialTrabajador ? initialTrabajador.telefono : '',
    email: initialTrabajador ? initialTrabajador.email : '',
    contacto_emergencia: initialTrabajador ? initialTrabajador.contacto_emergencia : '',
    telefono_emergencia: initialTrabajador ? initialTrabajador.telefono_emergencia : '',
    estado_id: initialTrabajador ? initialTrabajador.estado_id : '',
  });

  const [previewUrl, setPreviewUrl] = useState(formData.foto || '');
  const theme = useTheme();


  const [empresas, setEmpresas] = useState([]);
  const [usuarios, setUsuarios] = useState([]);
  const [cargos, setCargos] = useState([]);
  const [sexos, setSexos] = useState([]);
  const [comunas, setComunas] = useState([]);
  const [selectedFile, setSelectedFile] = useState([]);

  useEffect(() => {
    fetchEmpresas();
    fetchUsuarios();
    fetchCargos();
    fetchSexos();
    fetchComunas();
    if (selectedFile) {
      setFormData({ ...formData, foto: selectedFile });
    }
  }, [selectedFile]);

  const handleFileChange = (event) => {
    const file = event.target.files[0];

    if (!isValidImage(file)) {
      alert('Please select a valid image file (JPEG, PNG, or GIF)');
      return;
    }

    const selectedFile = file;
    setFormData({ ...formData, foto: file });
    setSelectedFile(file);

    const reader = new FileReader();
    reader.onload = (e) => setPreviewUrl(e.target.result);
    reader.readAsDataURL(file);

  };

  const isValidImage = (file) => {
    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxSizeInBytes = 5 * 1024 * 1024; // 5MB
  
    if (!file) return false;
    if (!validTypes.includes(file.type)) return false;
    if (file.size > maxSizeInBytes) return false;
  
    return true;
  };

  const fetchEmpresas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/empresas`);
      setEmpresas(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de empresas:', error);
    }
  };

  const fetchUsuarios = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/users`);
      setUsuarios(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de usuarios:', error);
    }
  };

  const fetchCargos = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/cargos`);
      setCargos(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de cargos:', error);
    }
  };

  const fetchSexos = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/sexo`);
      setSexos(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de sexos:', error);
    }
  };

  const fetchComunas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/comunas`);
      setComunas(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de comunas:', error);
    }
  };

  const handleChange = (e) => {
      setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(formData);

  };
  
  return (
    <form onSubmit={handleSubmit}>
      <Grid container spacing={2} alignItems="center">
        <Grid item xs={12} sm={12}>
          <TextField
            variant="outlined"
            fullWidth
            type="file"
            id="foto"
            label="Foto"
            name="foto"
            onChange={handleFileChange}
            InputProps={{
              endAdornment: (
                <IconButton color="primary">
                  <PhotoLibraryOutlinedIcon />
                </IconButton>
              ),
            }}
            helperText={previewUrl ? 'Imagen seleccionada' : 'Selecciona una imagen'}
            sx={{
              '& .MuiInputBase-root': {
                display: 'flex',
                alignItems: 'center',
              },
            }}
          />
          {previewUrl && (
            <img src={previewUrl} alt="Selected Image Preview" style={{ width: '100%', maxWidth: 300, marginTop: theme.spacing(1) }} />
          )}
        </Grid>
        <Grid item xs={12} sm={6}>
        <TextField
            variant="outlined"
            
            fullWidth
            id="empresa_id"
            label="Empresa"
            name="empresa_id"
            select
            value={formData.empresa_id}
            onChange={handleChange}
          >
          {empresaId === ''
            ? empresas.map((empresa) => (
                <MenuItem
                  key={empresa.id}
                  value={empresa.id}
                  selected={initialTrabajador && empresa.id === initialTrabajador.empresa_id}
                >
                  {empresa.RazonSocial}
                </MenuItem>
              ))
            : empresas
                .filter((empresa) => empresa.id === empresaId)
                .map((empresa) => (
                  <MenuItem
                    key={empresa.id}
                    value={empresa.id}
                    selected={initialTrabajador && empresa.id === initialTrabajador.empresa_id}
                  >
                    {empresa.RazonSocial}
                  </MenuItem>
                ))}
          </TextField>
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="user_id"
            label="Usuario"
            name="user_id"
            select
            value={formData.user_id}
            onChange={handleChange}
          >
            {usuarios.map((usuario) => (
              <MenuItem key={usuario.id} value={usuario.id} selected={initialTrabajador && usuario.id === initialTrabajador.user_id}>
                {usuario.userEmail}
              </MenuItem>
            ))}
          </TextField>
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="rut"
            label="Rut"
            name="rut"
            value={formData.rut}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="dv"
            label="Dv"
            name="dv"
            value={formData.dv}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="apellido_paterno"
            label="Apellido Paterno"
            name="apellido_paterno"
            value={formData.apellido_paterno}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="apellido_materno"
            label="Apellido Materno"
            name="apellido_materno"
            value={formData.apellido_materno}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="nombres"
            label="Nombres"
            name="nombres"
            value={formData.nombres}
            onChange={handleChange}
          />
        </Grid>       
         <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="nombre_social"
            label="Nombre Social"
            name="nombre_social"
            value={formData.nombre_social}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="fecha_nac"
            label="Fecha de Nacimiento"
            name="fecha_nac"
            type="date"
            InputLabelProps={{
              shrink: true,
            }}
            value={formData.fecha_nac}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="nacionalidad"
            label="Nacionalidad"
            name="nacionalidad"
            value={formData.nacionalidad}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="cargo_id"
            label="Cargo"
            name="cargo_id"
            select
            value={formData.cargo_id}
            onChange={handleChange}
          >
            {cargos.map((cargo) => (
              <MenuItem key={cargo.id} value={cargo.id} selected={initialTrabajador && cargo.id === initialTrabajador.cargo_id}>
                {cargo.nombre}
              </MenuItem>
            ))}
          </TextField>
        </Grid>      
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="sexo_id"
            label="Sexo"
            name="sexo_id"
            select
            value={formData.sexo_id}
            onChange={handleChange}
          >
            {sexos.map((sexo) => (
              <MenuItem key={sexo.id} value={sexo.id} selected={initialTrabajador && sexo.id === initialTrabajador.sexo_id}>
                {sexo.nombre}
              </MenuItem>
            ))}
          </TextField>
        </Grid>

        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="direccion"
            label="Dirección"
            name="direccion"
            value={formData.direccion}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="comuna_id"
            label="Comuna"
            name="comuna_id"
            select
            value={formData.comuna_id}
            onChange={handleChange}
          >
            {comunas.map((comuna) => (
              <MenuItem key={comuna.id} value={comuna.id} selected={initialTrabajador && comuna.id === initialTrabajador.comuna_id}>
                {comuna.nombre}
              </MenuItem>
            ))}
          </TextField>
        </Grid>        
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="telefono"
            label="Teléfono"
            name="telefono"
            value={formData.telefono}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="email"
            label="Email"
            name="email"
            value={formData.email}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="contacto_emergencia"
            label="Contacto Emergencia"
            name="contacto_emergencia"
            value={formData.contacto_emergencia}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="telefono_emergencia"
            label="Teléfono Emergencia"
            name="telefono_emergencia"
            value={formData.telefono_emergencia}
            onChange={handleChange}
          />
        </Grid>        
        <Grid item xs={12} sm={12}>
          <TextField
            variant="outlined"
            fullWidth
            id="estado_id"
            label="Estado"
            name="estado_id"
            select
            value={formData.estado_id}
            onChange={handleChange}
          >
            <MenuItem value="1">Activo</MenuItem>
            <MenuItem value="0">Inactivo</MenuItem>
          </TextField>
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
            onClick={onCancel} // Cambiar esto a la función para volver a la lista de Trabajadors
          >
            Volver a la lista de Trabajadores
          </Button>
        </Grid>
      </Grid>
    </form>
  );
};

export default TrabajadorForm;