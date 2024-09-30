import React, { useState, useEffect } from 'react';
import { Card, CardContent, Typography, RadioGroup, FormControlLabel, Radio, TextField, Button, Grid, FormControl, InputLabel, Select, MenuItem } from '@mui/material';
import Swal from 'sweetalert2';
import { useSelector } from 'react-redux';
import axios from 'axios';
import { API_BASE_URL } from './apiConstants';
import { setRoleSession } from '../../actions';
import { useNavigate } from 'react-router-dom';

const Perfiles = () => {
  const [passwordData, setPasswordData] = useState({
    newPassword: '',
    confirmPassword: '',
  });
  const [passwordError, setPasswordError] = useState('');
  const token = useSelector((state) => state.token); // Retrieve token from Redux
  const userDNI = useSelector((state) => state.userDNI);
  const nombre = useSelector((state) => state.nombre);
  const username = useSelector((state) => state.username); // Asumiendo que el nombre de usuario está en Redux
  const roleSession = useSelector((state) => state.roleSession); // Asumiendo que el nombre de usuario está en Redux
  const [roles, setRoles] = useState([]);

  const handleChange = (e) => {
    setPasswordData({ ...passwordData, [e.target.name]: e.target.value });
  };

  useEffect(() => {
    fetchRoles();
  }, []);
  const navigate = useNavigate();

  const fetchRoles = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/roles/all/${token}`);
      const sortedData = response.data.sort((a, b) => a.roleName.localeCompare(b.roleName));
      setRoles(sortedData);

    } catch (error) {
      console.error('Error al obtener la lista de usuarios:', error);
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (passwordData.newPassword !== passwordData.confirmPassword) {
      setPasswordError('Las contraseñas no coinciden');
    } else if (!passwordData.newPassword) {
      setPasswordError('La nueva contraseña no debe estar vacía');
    } else {
      setPasswordError('');
      try {
        await axios.post(`${API_BASE_URL}/users/change-password`, {
          userDNI,
          newPassword: passwordData.newPassword,
        }, {
          headers: { Authorization: `Bearer ${token}` },
        });

        Swal.fire({
          icon: 'success',
          title: 'Contraseña actualizada',
          text: 'Tu contraseña ha sido cambiada con éxito.',
          confirmButtonText: 'OK',
        });

        setPasswordData({ currentPassword: '', newPassword: '', confirmPassword: '' });
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un problema al cambiar la contraseña. Por favor, intenta nuevamente.',
          confirmButtonText: 'OK',
        });
        console.error('Error al cambiar la contraseña:', error);
      }
    }
  };

  return (
    <Card sx={{ maxWidth: 600, margin: 'auto', padding: 2 }}>
      <CardContent>
        <Typography variant="h5" gutterBottom>
          Cambiar Contraseña
        </Typography>
        <form onSubmit={handleSubmit}>
          <Grid container spacing={2}>
          <Grid item xs={12} sm={12}>
              <TextField
                variant="outlined"
                disabled
                required
                fullWidth
                id="userFullName"
                label="Nombre de usuario"
                name="userFullName"
                value={nombre}
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
                disabled
                fullWidth
                id="userDNI"
                label="Rut"
                name="userDNI"
                value={userDNI}
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
                disabled
                fullWidth
                id="role_id"
                label="Rol"
                name="role_id"
                select
                value={roleSession}
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
                  <MenuItem key={rol.id} value={rol.id} selected={rol.id === roleSession}>
                    {rol.roleName}
                  </MenuItem>
                ))}
              </TextField>
            </Grid>
            <Grid item xs={12} sm={12}>
              <TextField
                variant="outlined"
                disabled
                required
                fullWidth
                id="userEmail"
                label="Email"
                name="userEmail"
                value={username}
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
              <TextField
                variant="outlined"
                required
                fullWidth
                id="newPassword"
                label="Nueva contraseña"
                name="newPassword"
                type="password"
                value={passwordData.newPassword}
                onChange={handleChange}
                InputLabelProps={{ style: { color: 'black' } }}
                InputProps={{ style: { color: 'black' } }}
              />
            </Grid>
            <Grid item xs={6}>
              <TextField
                variant="outlined"
                required
                fullWidth
                id="confirmPassword"
                label="Confirmar nueva contraseña"
                name="confirmPassword"
                type="password"
                value={passwordData.confirmPassword}
                onChange={handleChange}
                InputLabelProps={{ style: { color: 'black' } }}
                InputProps={{ style: { color: 'black' } }}
              />
            </Grid>
            {passwordError && (
              <Grid item xs={12}>
                <p style={{ color: 'red' }}>{passwordError}</p>
              </Grid>
            )}
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
          </Grid>
        </form>
      </CardContent>
    </Card>
  );
};

export default Perfiles;
