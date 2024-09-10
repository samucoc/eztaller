import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import TipoSolForm from './TipoSolForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const TipoSols = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedTipoSol, setSelectedTipoSol] = useState(null); // State for selected TipoSol
  const [TipoSols, setTipoSols] = useState([]); // Use state to manage TipoSols

  // Fetch TipoSols on component mount
  useEffect(() => {
    const fetchTipoSols = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/tipoSol`);
        setTipoSols(response.data);
      } catch (error) {
        console.error('Error fetching TipoSols:', error);
      }
    };

    fetchTipoSols();
  }, []);

  const deleteTipoSol = async (id) => {
    try {
      const response = await axios.delete(API_BASE_URL+`/TipoSol/${id}`); // Delete request with TipoSol ID
  
      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setTipoSols(TipoSols.filter(TipoSol => TipoSol.id !== id)); // Filter out deleted TipoSol
        console.log('TipoSol eliminada exitosamente');
      } else {
        console.error('Error al eliminar la TipoSol:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
    }
  };

  const addTipoSol = async (TipoSolData) => {
    try {
        var initialTipoSol = selectedTipoSol
      const url = initialTipoSol ? `${API_BASE_URL}/tipoSol/${initialTipoSol.id}` : `${API_BASE_URL}/tipoSol`;
      const method = initialTipoSol ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: TipoSolData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedTipoSol = response.data; // Assuming your API returns the updated TipoSol
        
        if (initialTipoSol) { // Update scenario, update state with modified TipoSol
          setTipoSols(TipoSols.map(TipoSol => TipoSol.id === updatedTipoSol.id ? updatedTipoSol : TipoSol));
        } else { // Create scenario, add new TipoSol to state
          setTipoSols([...TipoSols, updatedTipoSol]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialTipoSol ? 'TipoSol actualizada exitosamente' : 'TipoSol agregada exitosamente');
      } else {
        console.error(initialTipoSol ? 'Error al actualizar la TipoSol:' : 'Error al agregar la TipoSol:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialTipoSol ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const editTipoSol = (TipoSol) => {
    setSelectedTipoSol(TipoSol);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedTipoSol(null);
  };

  return (
    <div className="container TipoSols">
      <h3>Tipo de Solicitudes</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar Tipo de Solicitud
            </Button>
      </div>
      {showForm ? (
        <TipoSolForm
          onSubmit={addTipoSol}
          initialTipoSol={selectedTipoSol}
          onCancel={handleCancel}
        />
      ) : (
        <TableContainer component={Paper}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>Nombre</TableCell>
                <TableCell>Acciones</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {TipoSols.map((TipoSol) => (
                <TableRow key={TipoSol.id}>
                  <TableCell>{TipoSol.nombre}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editTipoSol(TipoSol)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deleteTipoSol(TipoSol.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default TipoSols;