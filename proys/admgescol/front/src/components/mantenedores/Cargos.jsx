import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import CargoForm from './CargoForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const Cargos = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedcargo, setSelectedcargo] = useState(null); // State for selected cargo
  const [Cargos, setCargos] = useState([]); // Use state to manage Cargos

  // Fetch Cargos on component mount
  useEffect(() => {
    const fetchCargos = async () => {
      try {
        const response = await axios.get(API_BASE_URL+'/cargos'); // Replace with your API endpoint
        setCargos(response.data);
      } catch (error) {
        console.error('Error fetching Cargos:', error);
      }
    };

    fetchCargos();
  }, []);

  const deletecargo = async (id) => {
    try {
      const response = await axios.delete(API_BASE_URL+`/cargos/${id}`); // Delete request with cargo ID
  
      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setCargos(Cargos.filter(cargo => cargo.id !== id)); // Filter out deleted cargo
        console.log('cargo eliminada exitosamente');
      } else {
        console.error('Error al eliminar la cargo:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
    }
  };

  const addcargo = async (cargoData) => {
    try {
        var initialcargo = selectedcargo
      const url = initialcargo ? `${API_BASE_URL}/cargos/${initialcargo.id}` : `${API_BASE_URL}/cargos`;
      const method = initialcargo ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: cargoData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedcargo = response.data; // Assuming your API returns the updated cargo
        
        if (initialcargo) { // Update scenario, update state with modified cargo
          setCargos(Cargos.map(cargo => cargo.id === updatedcargo.id ? updatedcargo : cargo));
        } else { // Create scenario, add new cargo to state
          setCargos([...Cargos, updatedcargo]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialcargo ? 'cargo actualizada exitosamente' : 'cargo agregada exitosamente');
      } else {
        console.error(initialcargo ? 'Error al actualizar la cargo:' : 'Error al agregar la cargo:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialcargo ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const editcargo = (cargo) => {
    setSelectedcargo(cargo);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedcargo(null);
  };

  return (
    <div className="container Cargos">
      <h3>Cargos</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
          variant="contained"
          color="primary"
          startIcon={<AddIcon />}
          onClick={() => setShowForm(true)}
        >
          Agregar cargo
        </Button>
      </div>
      {showForm ? (
        <CargoForm
          onSubmit={addcargo}
          initialcargo={selectedcargo}
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
              {Cargos.map((cargo) => (
                <TableRow key={cargo.id}>
                  <TableCell>{cargo.nombre}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editcargo(cargo)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deletecargo(cargo.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default Cargos;