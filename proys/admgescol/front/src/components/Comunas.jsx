import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from './apiConstants'; // Assuming API_BASE_URL is defined here
import ComunaForm from './ComunaForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const Comunas = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedComuna, setSelectedComuna] = useState(null); // State for selected comuna
  const [comunas, setComunas] = useState([]); // Use state to manage comunas

  // Fetch comunas on component mount
  useEffect(() => {
    const fetchComunas = async () => {
      try {
        const response = await axios.get(API_BASE_URL+'/comunas'); // Replace with your API endpoint
        setComunas(response.data);
      } catch (error) {
        console.error('Error fetching comunas:', error);
      }
    };

    fetchComunas();
  }, []);

  const deleteComuna = async (id) => {
    try {
      const response = await axios.delete(API_BASE_URL+`/comunas/${id}`); // Delete request with comuna ID
  
      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setComunas(comunas.filter(comuna => comuna.id !== id)); // Filter out deleted comuna
        console.log('Comuna eliminada exitosamente');
      } else {
        console.error('Error al eliminar la comuna:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
    }
  };

  const addComuna = async (comunaData) => {
    try {
        var initialComuna = selectedComuna
      const url = initialComuna ? `${API_BASE_URL}/comunas/${initialComuna.id}` : `${API_BASE_URL}/comunas`;
      const method = initialComuna ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: comunaData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedComuna = response.data; // Assuming your API returns the updated comuna
        
        if (initialComuna) { // Update scenario, update state with modified comuna
          setComunas(comunas.map(comuna => comuna.id === updatedComuna.id ? updatedComuna : comuna));
        } else { // Create scenario, add new comuna to state
          setComunas([...comunas, updatedComuna]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialComuna ? 'Comuna actualizada exitosamente' : 'Comuna agregada exitosamente');
      } else {
        console.error(initialComuna ? 'Error al actualizar la comuna:' : 'Error al agregar la comuna:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialComuna ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const editComuna = (comuna) => {
    setSelectedComuna(comuna);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedComuna(null);
  };

  return (
    <div className="container comunas">
      <h3>Comunas</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar Comuna
            </Button>
      </div>
      {showForm ? (
        <ComunaForm
          onSubmit={addComuna}
          initialComuna={selectedComuna}
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
              {comunas.map((comuna) => (
                <TableRow key={comuna.id}>
                  <TableCell>{comuna.nombre}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editComuna(comuna)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deleteComuna(comuna.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default Comunas;