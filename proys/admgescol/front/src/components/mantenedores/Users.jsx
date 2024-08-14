import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import UsersForm from './UsersForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const Users = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedUser, setSelectedUser] = useState(null); // State for selected User
  const [Users, setUsers] = useState([]); // Use state to manage Users

  const fetchUsers = async () => {
    try {
      const response = await axios.get(API_BASE_URL+'/users'); // Replace with your API endpoint
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
      const response = await axios.delete(API_BASE_URL+`/users/${id}`); // Delete request with User ID
  
      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setUsers(Users.filter(User => User.id !== id)); // Filter out deleted User
        console.log('User eliminada exitosamente');
      } else {
        console.error('Error al eliminar la User:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
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
        <TableContainer component={Paper}>
          <Table>
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
      )}
    </div>
  );
};

export default Users;