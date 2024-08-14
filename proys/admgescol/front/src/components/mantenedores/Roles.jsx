import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import RolForm from './RolesForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const Roles = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedRol, setSelectedRol] = useState(null); // State for selected Rol
  const [Roles, setRoles] = useState([]); // Use state to manage Roles

  // Fetch Roles on component mount
  useEffect(() => {
    const fetchRoles = async () => {
      try {
        const response = await axios.get(API_BASE_URL+'/roles'); // Replace with your API endpoint
        setRoles(response.data);
      } catch (error) {
        console.error('Error fetching Roles:', error);
      }
    };

    fetchRoles();
  }, []);

  const deleteRol = async (id) => {
    try {
      const response = await axios.delete(API_BASE_URL+`/roles/${id}`); // Delete request with Rol ID
  
      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setRoles(Roles.filter(Rol => Rol.id !== id)); // Filter out deleted Rol
        console.log('Rol eliminada exitosamente');
      } else {
        console.error('Error al eliminar la Rol:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
    }
  };

  const addRol = async (RolData) => {
    try {
        var initialRol = selectedRol
      const url = initialRol ? `${API_BASE_URL}/roles/${initialRol.id}` : `${API_BASE_URL}/roles`;
      const method = initialRol ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: RolData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedRol = response.data; // Assuming your API returns the updated Rol
        
        if (initialRol) { // Update scenario, update state with modified Rol
          setRoles(Roles.map(Rol => Rol.id === updatedRol.id ? updatedRol : Rol));
        } else { // Create scenario, add new Rol to state
          setRoles([...Roles, updatedRol]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialRol ? 'Rol actualizada exitosamente' : 'Rol agregada exitosamente');
      } else {
        console.error(initialRol ? 'Error al actualizar la Rol:' : 'Error al agregar la Rol:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialRol ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const editRol = (Rol) => {
    console.log(Rol)
    setSelectedRol(Rol);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedRol(null);
  };

  return (
    <div className="container Roles">
      <h3>Roles</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar Roles
            </Button>
      </div>
      {showForm ? (
        <RolForm
          onSubmit={addRol}
          initialRoles={selectedRol}
          onCancel={handleCancel}
        />
      ) : (
        <TableContainer component={Paper}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>ID</TableCell>
                <TableCell>Nombre</TableCell>
                <TableCell>Acciones</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {Roles.map((Rol) => (
                <TableRow key={Rol.id}>
                  <TableCell>{Rol.id}</TableCell>
                  <TableCell>{Rol.roleName}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editRol(Rol)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deleteRol(Rol.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default Roles;