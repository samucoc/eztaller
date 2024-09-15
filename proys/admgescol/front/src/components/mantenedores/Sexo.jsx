import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import SexForm from './SexoForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import Swal from 'sweetalert2';

import { useSelector } from 'react-redux';

const Sexo = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedsex, setSelectedsex] = useState(null); // State for selected sex
  const [Sexo, setSexo] = useState([]); // Use state to manage Sexo
  const token = useSelector((state) => state.token);

  // Fetch Sexo on component mount
  useEffect(() => {
    const fetchSexo = async () => {
      try {
        const response = await axios.get(API_BASE_URL+'/sexo/all/'+token); // Replace with your API endpoint
        const sortedData = response.data.sort((a, b) => a.nombre.localeCompare(b.nombre));
        setSexo(sortedData);
      } catch (error) {
        console.error('Error fetching Sexo:', error);
      }
    };

    fetchSexo();
  }, []);

  const deletesex = async (id) => {
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
        const response = await axios.delete(`${API_BASE_URL}/sexo/${id}`);
  
        if (response.status === 200) {
          setSexo(Sexo.filter(comunicacion => comunicacion.id !== id));
  
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

  const addsex = async (sexData) => {
    try {
        var initialsex = selectedsex
      const url = initialsex ? `${API_BASE_URL}/sexo/${initialsex.id}` : `${API_BASE_URL}/sexo`;
      const method = initialsex ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: sexData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedsex = response.data; // Assuming your API returns the updated sex
        
        if (initialsex) { // Update scenario, update state with modified sex
          setSexo(Sexo.map(sex => sex.id === updatedsex.id ? updatedsex : sex));
        } else { // Create scenario, add new sex to state
          setSexo([...Sexo, updatedsex]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialsex ? 'sex actualizada exitosamente' : 'sex agregada exitosamente');
      } else {
        console.error(initialsex ? 'Error al actualizar la sex:' : 'Error al agregar la sex:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialsex ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const editsex = (sex) => {
    setSelectedsex(sex);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedsex(null);
  };

  return (
    <div className="container Sexo">
      <h3>Sexo</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar sexo
            </Button>
      </div>
      {showForm ? (
        <SexForm
          onSubmit={addsex}
          initialsex={selectedsex}
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
              {Sexo.map((sex) => (
                <TableRow key={sex.id}>
                  <TableCell>{sex.nombre}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editsex(sex)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deletesex(sex.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default Sexo;