import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import EstadoSolForm from './EstadoSolForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const EstadoSols = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedEstadoSol, setSelectedEstadoSol] = useState(null); // State for selected EstadoSol
  const [EstadoSols, setEstadoSols] = useState([]); // Use state to manage EstadoSols

  // Fetch EstadoSols on component mount
  useEffect(() => {
    const fetchEstadoSols = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/estadoSol`);
        setEstadoSols(response.data);
      } catch (error) {
        console.error('Error fetching EstadoSols:', error);
      }
    };

    fetchEstadoSols();
  }, []);

  const deleteEstadoSol = async (id) => {
    try {
      const response = await axios.delete(API_BASE_URL+`/estadoSol/${id}`); // Delete request with EstadoSol ID
  
      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setEstadoSols(EstadoSols.filter(EstadoSol => EstadoSol.id !== id)); // Filter out deleted EstadoSol
        console.log('EstadoSol eliminada exitosamente');
      } else {
        console.error('Error al eliminar la EstadoSol:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
    }
  };

  const addEstadoSol = async (EstadoSolData) => {
    try {
        var initialEstadoSol = selectedEstadoSol
      const url = initialEstadoSol ? `${API_BASE_URL}/estadoSol/${initialEstadoSol.id}` : `${API_BASE_URL}/estadoSol`;
      const method = initialEstadoSol ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: EstadoSolData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedEstadoSol = response.data; // Assuming your API returns the updated EstadoSol
        
        if (initialEstadoSol) { // Update scenario, update state with modified EstadoSol
          setEstadoSols(EstadoSols.map(EstadoSol => EstadoSol.id === updatedEstadoSol.id ? updatedEstadoSol : EstadoSol));
        } else { // Create scenario, add new EstadoSol to state
          setEstadoSols([...EstadoSols, updatedEstadoSol]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialEstadoSol ? 'EstadoSol actualizada exitosamente' : 'EstadoSol agregada exitosamente');
      } else {
        console.error(initialEstadoSol ? 'Error al actualizar la EstadoSol:' : 'Error al agregar la EstadoSol:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialEstadoSol ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const editEstadoSol = (EstadoSol) => {
    setSelectedEstadoSol(EstadoSol);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedEstadoSol(null);
  };

  return (
    <div className="container EstadoSols">
      <h3>Estados de Solicitudes</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar Estado de Solicitud
            </Button>
      </div>
      {showForm ? (
        <EstadoSolForm
          onSubmit={addEstadoSol}
          initialEstadoSol={selectedEstadoSol}
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
              {EstadoSols.map((EstadoSol) => (
                <TableRow key={EstadoSol.id}>
                  <TableCell>{EstadoSol.id}</TableCell>
                  <TableCell>{EstadoSol.nombre}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editEstadoSol(EstadoSol)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deleteEstadoSol(EstadoSol.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default EstadoSols;