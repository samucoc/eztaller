import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import UsersForm from './UsersForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import { makeStyles } from '@material-ui/core/styles';
import Swal from 'sweetalert2';
import { useSelector } from 'react-redux';

const Users = () => {
  const useStyles = makeStyles({
    root: {
      width: '100%',
    },
    container: {
      maxHeight: 440,
    },
  });
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedUser, setSelectedUser] = useState(null); // State for selected User
  const [Users, setUsers] = useState([]); // Use state to manage Users
  const classes = useStyles();
  const token = useSelector((state) => state.token);

  const fetchUsers = async () => {
    try {
      const response = await axios.get(API_BASE_URL+`/users/all/${token}`); // Replace with your API endpoint
      setUsers(response.data);
    } catch (error) {
      console.error('Error fetching Users:', error);
    }
  };

  // Fetch Users on component mount
  useEffect(() => {
    fetchUsers();
  }, []);

  const deleteUser = async (id) => {
    try {
      // Mostrar confirmación con SweetAlert2
      const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar',
      });
  
      // Si el usuario confirma la eliminación
      if (result.isConfirmed) {
        const response = await axios.delete(`${API_BASE_URL}/users/${id}`);
  
        if (response.status === 200) {
          setUsers(Users.filter(comunicacion => comunicacion.id !== id));
  
          // Mostrar éxito con SweetAlert2
          Swal.fire(
            '¡Eliminado!',
            'El usuario ha sido eliminado exitosamente.',
            'success'
          );
        } else {
          // Mostrar error si la eliminación no fue exitosa
          Swal.fire(
            'Error',
            'Hubo un problema al eliminar el usuario.',
            'error'
          );
          console.error('Error al eliminar el usuario:', response.data);
        }
      }
    } catch (error) {
      // Mostrar error si ocurrió durante la solicitud
      Swal.fire(
        'Error',
        'Ocurrió un error durante la eliminación.',
        'error'
      );
      console.error('Error durante la eliminación:', error);
    }
  };

  const addUser = async (UserData) => {
    try {
        var initialUser = selectedUser
      const url = initialUser ? `${API_BASE_URL}/users/${initialUser.id}` : `${API_BASE_URL}/users`;
      const method = initialUser ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: UserData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedUser = response.data; // Assuming your API returns the updated User
        
        if (initialUser) { // Update scenario, update state with modified User
          setUsers(Users.map(User => User.id === updatedUser.id ? updatedUser : User));
        } else { // Create scenario, add new User to state
          setUsers([...Users, updatedUser]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialUser ? 'User actualizada exitosamente' : 'User agregada exitosamente');
      } else {
        console.error(initialUser ? 'Error al actualizar la User:' : 'Error al agregar la User:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialUser ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
    fetchUsers();
  };

  const editUser = (User) => {
    setSelectedUser(User);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedUser(null);
  };

  return (
    <div className="container Users">
      <h3>Usuarios</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar Usuario
            </Button>
      </div>
      {showForm ? (
        <UsersForm
          onSubmit={addUser}
          initialUser={selectedUser}
          onCancel={handleCancel}
        />
      ) : (
        <Paper className={classes.root}>
        <TableContainer 
          className={classes.container}
          >
          <Table stickyHeader>
            <TableHead>
              <TableRow>
                <TableCell>ID</TableCell>
                <TableCell>Rol</TableCell>
                <TableCell>Rut</TableCell>
                <TableCell>Nombre</TableCell>
                <TableCell>Email</TableCell>
                <TableCell>Acciones</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {Users.map((User) => (
                <TableRow key={User.id}>
                  <TableCell>{User.id}</TableCell>
                  <TableCell>{User.role?.roleName}</TableCell>
                  <TableCell>{User.userDNI}</TableCell>
                  <TableCell>{User.userFullName}</TableCell>
                  <TableCell>{User.userEmail}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editUser(User)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deleteUser(User.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </TableContainer>
        </Paper>
      )}
    </div>
  );
};

export default Users;