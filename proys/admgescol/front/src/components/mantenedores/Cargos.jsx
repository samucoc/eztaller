import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import CargoForm from './CargoForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import Swal from 'sweetalert2';

import { useSelector } from 'react-redux';

const Cargos = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedcargo, setSelectedcargo] = useState(null); // State for selected cargo
  const [Cargos, setCargos] = useState([]); // Use state to manage Cargos
  const token = useSelector((state) => state.token);
  
  // Fetch Cargos on component mount
  useEffect(() => {
    const fetchCargos = async () => {
      try {

        const response = await axios.get(API_BASE_URL+'/cargos/all/'+token); // Replace with your API endpoint
        const sortedData = response.data.sort((a, b) => a.nombre.localeCompare(b.nombre));
        setCargos(sortedData);
      } catch (error) {
        console.error('Error fetching Cargos:', error);
      }
    };

    fetchCargos();
  }, []);

  const deletecargo = async (id) => {
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
        const response = await axios.delete(`${API_BASE_URL}/cargos/${id}`);
  
        if (response.status === 200) {
          setCargos(Cargos.filter(comunicacion => comunicacion.id !== id));
  
          // Mostrar éxito con SweetAlert2
          Swal.fire(
            '¡Eliminado!',
            'El registro ha sido eliminado exitosamente.',
            'success'
          );
        } else {
          // Mostrar error si la eliminación no fue exitosa
          Swal.fire(
            'Error',
            'Hubo un problema al eliminar el registro.',
            'error'
          );
          console.error('Error al eliminar el registro:', response.data);
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