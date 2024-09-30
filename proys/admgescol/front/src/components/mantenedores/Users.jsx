import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import UsersForm from './UsersForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, 
          TableRow, Paper, Tooltip, Button, TextField } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteOutlinedIcon from '@mui/icons-material/DeleteOutlined';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import { makeStyles } from '@material-ui/core/styles';
import Swal from 'sweetalert2';
import { useSelector } from 'react-redux';
import '../../css/Empresas.css';
import { Chip } from '@mui/material';
import DashboardTipoDoc from '../mantenedores/DashboardTipoDoc';

const Users = () => {
  const useStyles = makeStyles({
    root: {
      width: '100%',
    },
    container: {
      maxHeight: 550,
    },
  });
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedUser, setSelectedUser] = useState(null); // State for selected User
  const [Users, setUsers] = useState([]); // Use state to manage Users
  const [roles, setRoles] = useState([]); // Use state to manage Users
  const classes = useStyles();
  const token = useSelector((state) => state.token);

  const fetchUsers = async (newType) => {
    try {
      const response = await axios.get(API_BASE_URL+`/users/all/${token}`); // Replace with your API endpoint
      !newType ? setUsers(response.data) : setUsers(response.data.filter((doc) => doc.role.id === newType ));
    } catch (error) {
      console.error('Error fetching Users:', error);
    }
  };

  const fetchRoles = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/roles/all/${token}`); // Replace with your API endpoint
      setRoles(response.data);
    } catch (error) {
      console.error('Error fetching tipo_doc:', error);
    }
  };
  // Fetch Users on component mount
  useEffect(() => {
    fetchUsers(null);
    fetchRoles();
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
  const [docType, setDocType] = useState('');

  const handleDocTypeChangeTable = (newType) => {
    setDocType(newType);
    // Filtra y actualiza los documentos según el tipo seleccionado
    fetchUsers(newType);
  };

  const [searchTerm, setSearchTerm] = useState('');
  const handleSearch = (event) => setSearchTerm(event.target.value);
  let filteredUsers = Users.filter(trabajador =>
    [trabajador.userFullName, trabajador.userDNI, trabajador.role?.roleName, trabajador.userEmail, trabajador.userStatus].some(field =>
      (field || '').toString().toLowerCase().includes(searchTerm.toLowerCase())
    )
  );

  console.log(roles)

  return (
    <div className="container Users">
      {showForm ? (
        <UsersForm
          onSubmit={addUser}
          initialUser={selectedUser}
          onCancel={ () => {
                            handleCancel();     
                            fetchUsers(null);
                          }
                      }
        />
      ) : (
        <>
          <h3>Lista de Usuarios</h3>
          <DashboardTipoDoc tipoDocumentos={roles} onDocTypeChange={handleDocTypeChangeTable} />
          <div className="d-flex justify-content-between mb-3">
            {!showForm && (
              <>
                <TextField
                  label="Buscar"
                  variant="outlined"
                  value={searchTerm}
                  onChange={handleSearch}
                  style={{ marginBottom: '1rem' }}
                />
                <div></div> {/* Espacio en blanco */}
                <Button
                    variant="contained"
                    className="crear-empresa-btn" 
                    startIcon={<AddIcon />}
                    onClick={() => setShowForm(true)}
                    >
                    Crear Usuario
                </Button>
                </>
            )}
          </div>
          <Paper className={classes.root}>
          <TableContainer 
            className={classes.container}
            >
            <Table stickyHeader>
              <TableHead>
                <TableRow>
                  <TableCell>Nombre</TableCell>
                  <TableCell>Rut</TableCell>
                  <TableCell>Rol</TableCell>
                  <TableCell>Email</TableCell>
                  <TableCell>Status</TableCell>
                  <TableCell>Acciones</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {filteredUsers.map((User) => (
                  <TableRow key={User.id}>
                    <TableCell>{User.userFullName}</TableCell>
                    <TableCell>{User.userDNI}</TableCell>
                    <TableCell>{User.role?.roleName}</TableCell>
                    <TableCell>{User.userEmail}</TableCell>
                    <TableCell>
                          {User.userStatus === "1" ? (
                            <Chip label="Activo" color="primary" />
                          ) : (
                            <Chip label="Desactivado" sx={{ backgroundColor: '#dc3545', color: 'white' }} />
                          )}
                        </TableCell>
                    <TableCell>
                      <Tooltip title={'Editar Usuario'}>
                        <Button variant="text" color="primary" onClick={() => editUser(User)} startIcon={<EditIcon style={{width:'48px', height: '48px'}}/>}></Button>
                      </Tooltip>
                      <Tooltip title={'Eliminar Usuario'}>
                        <Button variant="text" color="secondary" disabled={User.userStatus === "0"} onClick={() => deleteUser(User.id)} startIcon={<DeleteOutlinedIcon style={{width:'48px', height: '48px'}}/>}></Button>
                      </Tooltip>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </TableContainer>
          </Paper>
        </>
        
      )}
    </div>
  );
};

export default Users;