import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import MenuItem from '@material-ui/core/MenuItem';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here 
import IconButton from '@mui/material/IconButton';
import PhotoLibraryOutlinedIcon from '@mui/icons-material/PhotoLibraryOutlined';
import { useTheme } from '@mui/material/styles';

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

  useEffect(() => {
    fetchRoles();
  }, []);
  
  const fetchRoles = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/roles`);
      setRoles(response.data);
    } catch (error) {
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
    <form onSubmit={handleSubmit}>
      <Grid container spacing={2} alignItems="center">
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            
            fullWidth
            id="role_id"
            label="Rol"
            name="role_id"
            select
            value={formData.role_id}
            onChange={handleChange}
          >
            {roles.map((rol) => (
              <MenuItem key={rol.id} value={rol.id} selected={initialUser && rol.id === initialUser.role_id}>
                {rol.roleName}
              </MenuItem>
            ))}
          </TextField>
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            required
            fullWidth
            id="userDNI"
            label="Rut"
            name="userDNI"
            value={formData.userDNI}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            required
            fullWidth
            id="userFullName"
            label="userFullName"
            name="userFullName"
            value={formData.userFullName}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            required
            fullWidth
            id="userEmail"
            label="Email"
            name="userEmail"
            value={formData.userEmail}
            onChange={handleChange}
          />
        </Grid>
        <Grid item xs={12} sm={6}>
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
          />
        </Grid>
        <Grid item xs={12} sm={6}>
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
          />
        </Grid>
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
            onClick={onCancel} // Cambiar esto a la función para volver a la lista de Users
          >
            Volver a la lista de Users
          </Button>
        </Grid>
      </Grid>
    </form>
  );
};

export default UserForm;
