import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Card, CardContent, Typography, RadioGroup, FormControlLabel, Radio, TextField, Button, Grid, FormControl, InputLabel, Select, MenuItem, Tabs, Tab, Box } from '@mui/material';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here 
import IconButton from '@mui/material/IconButton';
import PhotoLibraryOutlinedIcon from '@mui/icons-material/PhotoLibraryOutlined';
import { useTheme } from '@mui/material/styles';
import Swal from 'sweetalert2';
import { useNavigate } from 'react-router-dom';
import { useSelector } from 'react-redux'; // Importar useSelector
import '../../css/Empresas.css';

import PropTypes from 'prop-types';

const TabPanel = (props) => {
  const { children, value, index, ...other } = props;

  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`tabpanel-${index}`}
      aria-labelledby={`tab-${index}`}
      {...other}
    >
      {value === index && (
        <CardContent>{children}</CardContent>
      )}
    </div>
  );
};

TabPanel.propTypes = {
  children: PropTypes.node,
  index: PropTypes.any.isRequired,
  value: PropTypes.any.isRequired,
};

function a11yProps(index) {
  return {
    id: `tab-${index}`,
    'aria-controls': `tabpanel-${index}`,
  };
}

const TrabajadorForm = ({ onSubmit, onCancel, initialTrabajador, empresaId }) => {
  console.log(initialTrabajador)
  const [formData, setFormData] = useState({
    empresa_id: initialTrabajador ? initialTrabajador.empresa_id :'',
    user_id: initialTrabajador ? initialTrabajador.user_id :'',
    rut: initialTrabajador ? initialTrabajador.rut : '',
    dv: initialTrabajador ? initialTrabajador.dv : '',
    apellido_paterno: initialTrabajador ? initialTrabajador.apellido_paterno : '',
    apellido_materno: initialTrabajador ? initialTrabajador.apellido_materno : '',
    nombres: initialTrabajador ? initialTrabajador.nombres : '',
    fecha_nac: initialTrabajador ? initialTrabajador.fecha_nac : new Date(), 
    nacionalidad: initialTrabajador ? initialTrabajador.nacionalidad : '',
    cargo_id: initialTrabajador ? initialTrabajador.cargo_id :'',
    direccion: initialTrabajador ? initialTrabajador.direccion : '',
    comuna_id: initialTrabajador ? initialTrabajador.comuna_id :'',
    telefono: initialTrabajador ? initialTrabajador.telefono : '',
    email: initialTrabajador ? initialTrabajador.email : '',
    contacto_emergencia: initialTrabajador ? initialTrabajador.contacto_emergencia : '',
    telefono_emergencia: initialTrabajador ? initialTrabajador.telefono_emergencia : '',
    estado_id: initialTrabajador ? initialTrabajador.estado_id : '',
    fecha_ingreso: initialTrabajador ? initialTrabajador.fecha_ingreso : '',
    tipo_contrato: initialTrabajador ? initialTrabajador.tipo_contrato : '',
    region_id: initialTrabajador ? initialTrabajador.region_id :'',
    emailEmpresa: initialTrabajador ? initialTrabajador.emailEmpresa : '',
    contacto_emergencia_2: initialTrabajador ? initialTrabajador.contacto_emergencia_2 : '',
    telefono_emergencia_2: initialTrabajador ? initialTrabajador.telefono_emergencia_2 : '',
    email_emergencia_2: initialTrabajador ? initialTrabajador.email_emergencia_2 : '',
    email_emergencia: initialTrabajador ? initialTrabajador.email_emergencia : '',
    nro_cuenta: initialTrabajador ? initialTrabajador.nro_cuenta : '',
    tipo_cuenta: initialTrabajador ? initialTrabajador.tipo_cuenta : '',
    bancos: initialTrabajador ? initialTrabajador.bancos : '',
    salud: initialTrabajador ? initialTrabajador.salud : '',
    plan_salud: initialTrabajador ? initialTrabajador.plan_salud : '',
    afp: initialTrabajador ? initialTrabajador.afp : '',
    ingreso: initialTrabajador ? initialTrabajador.ingreso : '',
    plazo_contrato: initialTrabajador ? initialTrabajador.plazo_contrato : '',
    horas_trabajo: initialTrabajador ? initialTrabajador.horas_trabajo : '',
  });

  const [previewUrl, setPreviewUrl] = useState(initialTrabajador.foto || '');
  const theme = useTheme();
  const navigate = useNavigate();
  const token = useSelector((state) => state.token);
  const empresaIdS = useSelector((state) => state.empresaId);
  empresaId = empresaIdS 
  const [tabValue, setTabValue] = useState(0);
  const [rutError, setRutError] = useState('');

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

  const contractTypes = [
    { value: 'plazo_fijo', label: 'Contrato a Plazo Fijo' },
    { value: 'indefinido', label: 'Contrato Indefinido' },
    { value: 'obra_faena', label: 'Contrato de Trabajo por Obra o Faena' },
    { value: 'tiempo_parcial', label: 'Contrato de Trabajo a Tiempo Parcial' },
    { value: 'tiempo_completo', label: 'Contrato de Trabajo a Tiempo Completo' },
    { value: 'necesidades_empresa', label: 'Contrato de Trabajo por Necesidades de la Empresa' },
    { value: 'trabajo_hogar', label: 'Contrato de Trabajo para el Hogar' },
    { value: 'menores_edad', label: 'Contrato de Trabajo para Menores de Edad' },
    { value: 'discapacidad', label: 'Contrato de Trabajo para Personas con Discapacidad' },
    { value: 'aprendizaje', label: 'Contrato de Aprendizaje' },
  ];

  // const handleFileChange = (event) => {
  //   const file = event.target.files[0];

  //   if (!isValidImage(file)) {
  //     alert('Please select a valid image file (JPEG, PNG, or GIF)');
  //     return;
  //   }

  //   const selectedFile = file;
  //   setFormData({ ...formData, foto: file });
  //   setSelectedFile(file);

  //   const reader = new FileReader();
  //   reader.onload = (e) => setPreviewUrl(e.target.result);
  //   reader.readAsDataURL(file);

  // };

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
      const response = await axios.get(`${API_BASE_URL}/empresas/all/${token}`);
      setEmpresas(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de empresas:', error);
    }
  };

  const fetchUsuarios = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/users/all/${token}`);
      setUsuarios(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de usuarios:', error);
    }
  };

  const fetchCargos = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/cargos/all/${token}`);
      setCargos(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de cargos:', error);
    }
  };

  const fetchSexos = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/sexo/all/${token}`);
      setSexos(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de sexos:', error);
    }
  };

  const fetchComunas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/comunas/all/${token}`);
      setComunas(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de comunas:', error);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;

    if (name === 'rut') {
        // Separate RUT and DV
        const cleanedRUT = value.replace(/[^0-9kK]/g, '');
        const rutBody = cleanedRUT.slice(0, -1);
        const dv = cleanedRUT.slice(-1).toUpperCase();

        if (!validateRUT(cleanedRUT)) {
            setRutError('RUT inválido');
        } else {
            setRutError('');
            setFormData({ ...formData, rut: rutBody, dv }); // Store RUT and DV separately
        }
    } else {
        setFormData({ ...formData, [name]: value });
    }
  };

  const handleChangeUser = (e) => {
    const selectedUserId = e.target.value;
    const selectedUser = usuarios.find(user => user.id === selectedUserId);
    setFormData({ ...formData, user_id: selectedUserId });
    setFormData({ ...formData, rut: selectedUser.userDNI });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(formData);
  };
  
  const desactivarTrabajador = async () => {
    try {
      await axios.get(`${API_BASE_URL}/trabajadores/desactivar-trabajador/${initialTrabajador.id}`);
      // Mostrar notificación de éxito usando SweetAlert2
      Swal.fire({
          icon: 'success',
          title: 'Trabajador desactivado',
          text: 'Trabajador desactivado con éxito.',
          confirmButtonText: 'OK',
      });
      navigate('/Empresas')
      onCancel()

    } catch (error) {
      Swal.fire({
          icon: 'error',
          title: 'Error al enviar solicitud',
          text: 'Hubo un problema al enviar tu solicitud. Por favor, intenta nuevamente.',
          confirmButtonText: 'OK',
      });
      console.error('Error al obtener la lista de usuarios:', error);
    }
  
  };

 
  const activarTrabajador = async () => {
    try {
      await axios.get(`${API_BASE_URL}/trabajadores/activar-trabajador/${initialTrabajador.id}`);
      // Mostrar notificación de éxito usando SweetAlert2
      Swal.fire({
          icon: 'success',
          title: 'Trabajador activado',
          text: 'Trabajador activado con éxito.',
          confirmButtonText: 'OK',
      });
      navigate('/Empresas')
      onCancel()

    } catch (error) {
      Swal.fire({
          icon: 'error',
          title: 'Error al enviar solicitud',
          text: 'Hubo un problema al enviar tu solicitud. Por favor, intenta nuevamente.',
          confirmButtonText: 'OK',
      });
      console.error('Error al obtener la lista de usuarios:', error);
    }
  
  };

  const handleTabChange = (event, newValue) => {
    setTabValue(newValue);
  };

  const validateRUT = (rut) => {
      // Remove any non-digit characters (except K)
      const cleanedRUT = rut.replace(/[^0-9kK]/g, '');
      
      if (cleanedRUT.length < 2) return false; // RUT must have at least 2 characters

      const body = cleanedRUT.slice(0, -1);
      const dv = cleanedRUT.slice(-1).toUpperCase();

      let sum = 0;
      let multiplier = 2;

      for (let i = body.length - 1; i >= 0; i--) {
          sum += parseInt(body[i], 10) * multiplier;
          multiplier = multiplier === 7 ? 2 : multiplier + 1;
      }

      const calculatedDV = 11 - (sum % 11);
      const expectedDV = calculatedDV === 11 ? '0' : calculatedDV === 10 ? 'K' : calculatedDV.toString();

      return dv === expectedDV;
  };

  const regionesDeChile = [
    'Región de Arica y Parinacota',
    'Región de Tarapacá',
    'Región de Antofagasta',
    'Región de Atacama',
    'Región de Coquimbo',
    'Región de Valparaíso',
    'Región Metropolitana de Santiago',
    'Región del Libertador General Bernardo O\'Higgins',
    'Región del Maule',
    'Región de Ñuble',
    'Región del Biobío',
    'Región de La Araucanía',
    'Región de Los Ríos',
    'Región de Los Lagos',
    'Región de Aysén del General Carlos Ibáñez del Campo',
    'Región de Magallanes y de la Antártica Chilena'
  ];

  const tiposDeCuenta = [
    'Cuenta Corriente',
    'Cuenta de Ahorro',
    'Cuenta Vista',
    'Cuenta RUT',
    'Cuenta Plazo Fijo',
    'Cuenta de Ahorro para la Vivienda',
  ];

  const bancos = [
    'Banco de Chile',
    'Banco Santander',
    'Banco Estado',
    'Banco BICE',
    'Banco Itaú',
    'Banco Falabella',
    'Scotiabank Chile',
    'HSBC Chile',
    'Coopeuch',
    'Banco Consorcio',
    'Banco Security',
    'Banco Ripley',
    'Banco Internacional',
    'Banco Agrícola',
    'Banco Paris',
    'Banco de Crédito e Inversiones (BCI)',
  ];

  const entidadesPrevision = [
    'AFP Habitat',
    'AFP Provida',
    'AFP Capital',
    'AFP Cuprum',
    'AFP Modelo',
    'AFP Planvital',
    'AFP Volcan',
    'AFP Los Andes',
    'Caja de Compensación Los Andes',
    'Caja de Compensación La Araucana',
    'Caja de Compensación Gabriela Mistral',
    'Caja de Compensación 18 de Septiembre',
    'Caja de Compensación Copeuch',
    'Rentas Vitalicias Consorcio',
    'Rentas Vitalicias BICE',
    'Rentas Vitalicias MetLife',
    'Rentas Vitalicias AFP Habitat',
  ];

  const sistemasSaludChile = [
    { id: 1, tipo: 'FONASA', nombre: 'Fondo Nacional de Salud' },
    { id: 2, tipo: 'ISAPRE', nombre: 'Isapre BICE Vida' },
    { id: 3, tipo: 'ISAPRE', nombre: 'Isapre Consalud' },
    { id: 4, tipo: 'ISAPRE', nombre: 'Isapre Cruz Blanca' },
    { id: 5, tipo: 'ISAPRE', nombre: 'Isapre Colmena' },
    { id: 6, tipo: 'ISAPRE', nombre: 'Isapre Banmedica' },
    { id: 7, tipo: 'ISAPRE', nombre: 'Isapre Vida Tres' },
    { id: 8, tipo: 'ISAPRE', nombre: 'Isapre San Lorenzo' },
    { id: 9, tipo: 'ISAPRE', nombre: 'Isapre Nueva Masvida' },
    { id: 10, tipo: 'ISAPRE', nombre: 'Isapre Grupo Salud' },
    { id: 11, tipo: 'OTRO', nombre: 'Seguro de Salud de las Fuerzas Armadas (FONDO AERONAUTICO)' },
    { id: 12, tipo: 'OTRO', nombre: 'Seguro de Salud de las Fuerzas Armadas (FONDO NAVAL)' },
    { id: 13, tipo: 'OTRO', nombre: 'Seguro de Salud de las Fuerzas Armadas (FONDO DEL EJÉRCITO)' },
    { id: 14, tipo: 'OTRO', nombre: 'Seguro de Salud de la Policía de Investigaciones' },
    { id: 15, tipo: 'OTRO', nombre: 'Seguro de Salud de Gendarmería' },
    { id: 16, tipo: 'OTRO', nombre: 'Seguro de Salud de Carabineros de Chile' }, 
  ];
  
  const tiposContratoChile = [
    { id: 1, nombre: 'Contrato a Plazo Fijo' },
    { id: 2, nombre: 'Contrato Indefinido' },
    { id: 3, nombre: 'Contrato por Obra o Faena' },
    { id: 4, nombre: 'Contrato de Aprendizaje' },
    { id: 5, nombre: 'Contrato de Práctica' },
    { id: 6, nombre: 'Contrato de Trabajo a Distancia' },
    { id: 7, nombre: 'Contrato de Servicios' },
    { id: 8, nombre: 'Contrato de Temporada' },
    { id: 9, nombre: 'Contrato de Reemplazo' },
    { id: 10, nombre: 'Contrato de Colaboración' },
  ];

  return (
    <Card sx={{ maxWidth: 1200, margin: 'auto', padding: 2 }}>
      <CardContent>
        <Typography variant="h5" gutterBottom>
          {initialTrabajador ? (
            'Editar'
          ):
          (
            'Crear'
          )} Trabajador        
        </Typography>
        <Tabs value={tabValue} onChange={handleTabChange} aria-label="Trabajador Form Tabs">
          <Tab label="Identificación" {...a11yProps(0)} />
          <Tab label="Contactos" {...a11yProps(1)} />
          <Tab label="Info Financiera" {...a11yProps(2)} />
          <Tab label="AFP y Salud" {...a11yProps(3)} />
          <Tab label="Contrato" {...a11yProps(4)} />
          {/* <Tab label="Sistema" {...a11yProps(5)} /> */}
        </Tabs>
    
        <form onSubmit={handleSubmit}>
          {/* Identificación */}
          <TabPanel value={tabValue} index={0}>
            <Grid container spacing={2}>
              {/* <Grid item xs={12}>
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
              </Grid> */}
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Nombres"
                  name="nombres"
                  value={formData.nombres}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Apellido Paterno"
                  name="apellido_paterno"
                  value={formData.apellido_paterno}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Apellido Materno"
                  name="apellido_materno"
                  value={formData.apellido_materno}
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
              <Grid item xs={4}>
                <TextField
                    variant="outlined"
                    fullWidth
                    label="RUT"
                    name="rut"
                    value={formData.rut}
                    onChange={handleChange}
                    error={!!rutError}
                    helperText={rutError}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ style: { color: 'black' } }}
                    InputProps={{ style: { color: 'black' } }}
                />
              </Grid>
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Fecha Nacimiento"
                  name="fecha_nac"
                  type="date"
                  InputLabelProps={{ shrink: true }}
                  value={formData.fecha_nac}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Nacionalidad"
                  name="nacionalidad"
                  value={formData.nacionalidad}
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
              <Grid item xs={4}>
                <FormControl fullWidth variant="outlined">
                  <InputLabel>Estado Civil</InputLabel>
                  <Select
                    name="estado_civil"
                    value={formData.estado_civil}
                    onChange={handleChange}
                    label="Estado Civil"
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  >
                    <MenuItem value="soltero">Soltero</MenuItem>
                    <MenuItem value="casado">Casado</MenuItem>
                    <MenuItem value="viudo">Viudo</MenuItem>
                    <MenuItem value="divorciado">Divorciado</MenuItem>
                  </Select>
                </FormControl>
              </Grid>
              <Grid item xs={8}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Profesión"
                  name="profesion"
                  value={formData.profesion}
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
          </TabPanel>
    
          {/* Contactos */}
          <TabPanel value={tabValue} index={1}>
            <Grid container spacing={2}>
              <Grid item xs={12}>
                <Typography variant="h7" gutterBottom>
                  Contacto Trabajador
                </Typography>
              </Grid>
              <Grid item xs={6}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Dirección"
                  name="direccion"
                  value={formData.direccion}
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
              <Grid item xs={3}>
                <FormControl fullWidth variant="outlined">
                  <InputLabel>Comuna</InputLabel>
                  <Select
                    name="comuna_id"
                    value={formData.comuna_id}
                    onChange={handleChange}
                    label="Comuna"
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
                  </Select>
                </FormControl>
              </Grid>
              <Grid item xs={3}>

                <FormControl fullWidth variant="outlined">
                  <InputLabel>Seleccionar Región</InputLabel>
                  <Select
                    value={formData.region_id}
                    onChange={handleChange}
                    label="Seleccionar Región"
                    sx={{ color: 'black' }}
                    InputLabelProps={{
                      style: { color: 'black' }, // Color de la etiqueta
                    }}
                    MenuProps={{
                      PaperProps: {
                        style: {
                          maxHeight: 300, // Altura máxima del menú desplegable
                        },
                      },
                    }}
                  >
                    {regionesDeChile.map((region, index) => (
                      <MenuItem key={index} value={region}>
                        {region}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Teléfono de Contacto"
                  name="telefono"
                  value={formData.telefono}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Email Personal"
                  name="email"
                  value={formData.email}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Email Corporativo"
                  name="email"
                  value={formData.emailEmpresa}
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
                <Typography variant="h7" gutterBottom>
                  Contacto Emergencia
                </Typography>
              </Grid>
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Contacto de Emergencia"
                  name="contacto_emergencia"
                  value={formData.contacto_emergencia}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Teléfono de Emergencia"
                  name="telefono_emergencia"
                  value={formData.telefono_emergencia}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Correo de Emergencia"
                  name="email_emergencia"
                  value={formData.email_emergencia}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Contacto de Emergencia"
                  name="contacto_emergencia_2"
                  value={formData.contacto_emergencia_2}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Teléfono de Emergencia"
                  name="telefono_emergencia_2"
                  value={formData.telefono_emergencia_2}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Correo de Emergencia"
                  name="email_emergencia_2"
                  value={formData.email_emergencia_2}
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
          </TabPanel>
    
          {/* Info Financiera */}
          <TabPanel value={tabValue} index={2}>
            <Grid container spacing={2}>
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Número Cuenta"
                  name="nro_cuenta"
                  value={formData.nro_cuenta}
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
              <Grid item xs={4}>
                <FormControl fullWidth variant="outlined">
                  <InputLabel>Tipo Cuenta</InputLabel>
                  <Select
                    name="tipo_cuenta"
                    value={formData.tipo_cuenta}
                    onChange={handleChange}
                    label="Tipo Cuenta"
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  >
                    {tiposDeCuenta.map((tipo, index) => (
                      <MenuItem key={index} value={tipo}>
                        {tipo}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>
              <Grid item xs={4}>
                <FormControl fullWidth variant="outlined">
                  <InputLabel>Bancos</InputLabel>
                  <Select
                    name="bancos"
                    value={formData.bancos}
                    onChange={handleChange}
                    label="Banco"
                    sx={{ color: 'black' }}
                    InputLabelProps={{
                      style: { color: 'black' }, // Color de la etiqueta
                    }}
                  >
                    {bancos.map((banco, index) => (
                      <MenuItem key={index} value={banco}>
                        {banco}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>
            </Grid>
          </TabPanel>
    
          {/* AFP y Salud */}
          <TabPanel value={tabValue} index={3}>
            <Grid container spacing={2}>
              <Grid item xs={6}>
                <FormControl fullWidth variant="outlined">
                  <TextField
                    variant="outlined"
                    fullWidth
                    label="Salud"
                    name="salud"
                    value={formData.salud}
                    onChange={handleChange}
                    select
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  >
                    {sistemasSaludChile.map((sistema) => (
                      <MenuItem key={sistema.nombre} value={sistema.nombre}>
                        {sistema.nombre}
                      </MenuItem>
                    ))}
                  </TextField>
                </FormControl>
              </Grid>
              <Grid item xs={6}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Plan/Tramo"
                  name="plan_salud"
                  value={formData.plan_salud}
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
                <FormControl fullWidth variant="outlined">
                  <InputLabel>AFP/Caja/Renta</InputLabel>
                  <Select
                    name="afp"
                    value={formData.afp}
                    onChange={handleChange}
                    label="AFP/Caja/Renta"
                    sx={{ color: 'black' }}
                    InputLabelProps={{
                      style: { color: 'black' }, // Color de la etiqueta
                    }}
                  >
                    {entidadesPrevision.map((entidad, index) => (
                      <MenuItem key={index} value={entidad}>
                        {entidad}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>
              <Grid item xs={6}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Ingreso"
                  name="ingreso"
                  value={formData.ingreso}
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
          </TabPanel>
    
          {/* Contrato */}
          <TabPanel value={tabValue} index={4}>
            <Grid container spacing={2}>
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Fecha de Ingreso"
                  name="fecha_ingreso"
                  type="date"
                  InputLabelProps={{ shrink: true }}
                  value={formData.fecha_ingreso}
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
              <Grid item xs={4}>
                <FormControl fullWidth variant="outlined">
                  <InputLabel>Tipo de Contrato</InputLabel>
                  <TextField
                    variant="outlined"
                    fullWidth
                    label="Tipo de Contrato"
                    name="tipo_contrato"
                    select
                    value={formData.tipo_contrato}
                    onChange={handleChange}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  >
                    {tiposContratoChile.map((tipo) => (
                      <MenuItem key={tipo.id} value={tipo.nombre}>
                        {tipo.nombre}
                      </MenuItem>
                    ))}
                  </TextField>
                </FormControl>
              </Grid>
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Plazo Contrato"
                  name="plazo_contrato"
                  type="date"
                  InputLabelProps={{ shrink: true }}
                  value={formData.plazo_contrato}
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
              <Grid item xs={4}>
                <TextField
                  variant="outlined"
                  fullWidth
                  label="Horas"
                  name="horas_trabajo"
                  value={formData.horas_trabajo}
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
          </TabPanel>
    
          {/* Foto
          <TabPanel value={tabValue} index={5}>
            
          </TabPanel> */}
    
        
    
          <Box sx={{ mt: 2, textAlign: 'center' }}>
            <Grid container spacing={2} alignItems="center">
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
              {initialTrabajador ? (
                  <>
                  {initialTrabajador.estado_id === "1" ? (
                    <Grid item xs={6}>
                      <Button
                        fullWidth
                        variant="text"
                        sx={{ color: 'red' }}
                        onClick={() => desactivarTrabajador(initialTrabajador.id)}
                      >
                        Desactivar Usuario
                      </Button>
                    </Grid>
                    ) : (
                      <Grid item xs={6}>
                        <Button
                          fullWidth
                          variant="text"
                          sx={{ color: 'red' }}
                          onClick={() => activarTrabajador(initialTrabajador.id)}
                        >
                          Activar Usuario
                        </Button>
                      </Grid>
                    )}
                  <Grid item xs={12} sm={12}>
                    <Button
                      fullWidth
                      variant="outlined"
                      onClick={onCancel}
                    >
                      Cancelar
                    </Button>
                  </Grid>
                  </>
                  
                ):(
                  <Grid item xs={6}>
                    <Button
                      fullWidth
                      variant="outlined"
                      onClick={onCancel}
                    >
                      Cancelar
                    </Button>
                  </Grid>
                )}
              </Grid>
          </Box>
        </form>
      </CardContent>
    </Card>
  );
  
};

export default TrabajadorForm;