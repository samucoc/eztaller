import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Card, CardContent, Typography, RadioGroup, FormControlLabel, Radio, TextField, Button, Grid, FormControl, InputLabel, Select, MenuItem } from '@mui/material';

import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here 
import IconButton from '@mui/material/IconButton';
import PhotoLibraryOutlinedIcon from '@mui/icons-material/PhotoLibraryOutlined';
import { useTheme } from '@mui/material/styles';
import '../../css/Empresas.css';
import { useSelector } from 'react-redux'; // Importar useSelector
import Swal from 'sweetalert2';

const UserForm = ({ onSubmit, onCancel, initialUser }) => {
  const [formData, setFormData] = useState({
    role_id: initialUser ? initialUser.role_id :'',
    userDNI: initialUser ? initialUser.userDNI :'',
    userFullName: initialUser ? initialUser.userFullName : '',
    userEmail: initialUser ? initialUser.userEmail : '',
    userPassword: initialUser ? initialUser.userPassword : '',
  });
  const [roles, setRoles] = useState([]);
  const [confirmPassword, setConfirmPassword] = useState('');
  const [passwordError, setPasswordError] = useState('');
  const token = useSelector((state) => state.token);

  useEffect(() => {
    fetchRoles();
  }, []);
  
  const fetchRoles = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/roles/all/${token}`);
      const sortedData = response.data.sort((a, b) => a.roleName.localeCompare(b.roleName));
      setRoles(sortedData);

    } catch (error) {
      console.error('Error al obtener la lista de usuarios:', error);
    }
  };

  const desactivarUsuario = async () => {
    try {
      await axios.get(`${API_BASE_URL}/users/desactivar-usuario/${initialUser.id}`);
      // Mostrar notificación de éxito usando SweetAlert2
      Swal.fire({
          icon: 'success',
          title: 'Usuario desactivado',
          text: 'Usuario desactivado con éxito.',
          confirmButtonText: 'OK',
      });
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

 
  const activarUsuario = async () => {
    try {
      await axios.get(`${API_BASE_URL}/users/activar-usuario/${initialUser.id}`);
      // Mostrar notificación de éxito usando SweetAlert2
      Swal.fire({
          icon: 'success',
          title: 'Usuario activado',
          text: 'Usuario activado con éxito.',
          confirmButtonText: 'OK',
      });
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

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleConfirmPasswordChange = (e) => {
    setConfirmPassword(e.target.value);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (formData.userPassword !== confirmPassword) {
      setPasswordError('Las contraseñas no coinciden');
    } else if (!formData.userPassword) {
      setPasswordError('La contraseña no debe estar vacía');
    } else {
      setPasswordError('');
      onSubmit(formData);
    }
  };

  return (
    <Card sx={{ maxWidth: 600, margin: 'auto', padding: 2 }}>
      <CardContent>
        <Typography variant="h5" gutterBottom>
          {initialUser ? (
            'Editar'
          ):
          (
            'Crear'
          )} Usuario
        </Typography>
        <form onSubmit={handleSubmit}>
          <Grid container spacing={2} alignItems="center">
            <Grid item xs={12} sm={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                id="userFullName"
                label="Nombre de usuario"
                name="userFullName"
                value={formData.userFullName}
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
            <Grid item xs={12} sm={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                id="userDNI"
                label="Rut"
                name="userDNI"
                value={formData.userDNI}
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
            <Grid item xs={12} sm={12}>
              <TextField
                variant="outlined"
                
                fullWidth
                id="role_id"
                label="Rol"
                name="role_id"
                select
                value={formData.role_id}
                onChange={handleChange}
                sx={{ color: 'black' }}
                InputLabelProps={{ 
                  style: { color: 'black' }  // Set label color
                }}
                InputProps={{ 
                  style: { color: 'black' }  // Set input text color
                }}
              >
                {roles.map((rol) => (
                  <MenuItem key={rol.id} value={rol.id} selected={initialUser && rol.id === initialUser.role_id}>
                    {rol.roleName}
                  </MenuItem>
                ))}
              </TextField>
            </Grid>
            <Grid item xs={12} sm={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                id="userEmail"
                label="Email"
                name="userEmail"
                value={formData.userEmail}
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
            <Grid item xs={12} sm={12}>
              <TextField
                variant="outlined"
                required
                fullWidth
                id="userPassword"
                label="Password"
                name="userPassword"
                type="password"
                value={formData.userPassword}
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
            {initialUser && (
              <Grid item xs={12} sm={12}>
                <TextField
                  variant="outlined"
                  required
                  fullWidth
                  id="confirm_pass"
                  label="Confirmar Password"
                  name="confirm_pass"
                  type="password"
                  value={confirmPassword}
                  onChange={handleConfirmPasswordChange}
                  sx={{ color: 'black' }}
                  InputLabelProps={{ 
                    style: { color: 'black' }  // Set label color
                  }}
                  InputProps={{ 
                    style: { color: 'black' }  // Set input text color
                  }}
                />
              </Grid>
            )}
            {passwordError && (
              <Grid item xs={12}>
                <p style={{ color: 'red' }}>{passwordError}</p>
              </Grid>
            )}
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
            {initialUser ? (
              <>
              {initialUser.userStatus === "1" ? (
                <Grid item xs={6}>
                  <Button
                    fullWidth
                    variant="text"
                    sx={{ color: 'red' }}
                    onClick={() => desactivarUsuario(initialUser.id)}
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
                      onClick={() => activarUsuario(initialUser.id)}
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
        </form>
      </CardContent>
    </Card>
  );
};

export default UserForm;
