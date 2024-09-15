import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import Tipo_DocForm from './Tipo_DocForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import Swal from 'sweetalert2';
import { useSelector } from 'react-redux';

const Tipo_Docs = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedTipo_Doc, setSelectedTipo_Doc] = useState(null); // State for selected Tipo_Doc
  const [Tipo_Docs, setTipo_Docs] = useState([]); // Use state to manage Tipo_Docs
  const token = useSelector((state) => state.token);

  // Fetch Tipo_Docs on component mount
  useEffect(() => {
    const fetchTipo_Docs = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/tipo_doc/all/${token}`); // Replace with your API endpoint
        const sortedData = response.data.sort((a, b) => a.nombre.localeCompare(b.nombre));
        setTipo_Docs(sortedData);
      } catch (error) {
        console.error('Error fetching Tipo_Docs:', error);
      }
    };

    fetchTipo_Docs();
  }, []);

  const deleteTipo_Doc = async (id) => {
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
        const response = await axios.delete(`${API_BASE_URL}/tipo_doc/${id}`);
  
        if (response.status === 200) {
          setTipo_Docs(Tipo_Docs.filter(comunicacion => comunicacion.id !== id));
  
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

  const addTipo_Doc = async (Tipo_DocData) => {
    try {
        var initialTipo_Doc = selectedTipo_Doc
      const url = initialTipo_Doc ? `${API_BASE_URL}/tipo_doc/${initialTipo_Doc.id}` : `${API_BASE_URL}/tipo_doc`;
      const method = initialTipo_Doc ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: Tipo_DocData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedTipo_Doc = response.data; // Assuming your API returns the updated Tipo_Doc
        
        if (initialTipo_Doc) { // Update scenario, update state with modified Tipo_Doc
          setTipo_Docs(Tipo_Docs.map(Tipo_Doc => Tipo_Doc.id === updatedTipo_Doc.id ? updatedTipo_Doc : Tipo_Doc));
        } else { // Create scenario, add new Tipo_Doc to state
          setTipo_Docs([...Tipo_Docs, updatedTipo_Doc]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialTipo_Doc ? 'Tipo_Doc actualizada exitosamente' : 'Tipo_Doc agregada exitosamente');
      } else {
        console.error(initialTipo_Doc ? 'Error al actualizar la Tipo_Doc:' : 'Error al agregar la Tipo_Doc:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialTipo_Doc ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const editTipo_Doc = (Tipo_Doc) => {
    setSelectedTipo_Doc(Tipo_Doc);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedTipo_Doc(null);
  };

  return (
    <div className="container Tipo_Docs">
      <h3>Tipo de Documentos</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar Tipo Documento
            </Button>
      </div>
      {showForm ? (
        <Tipo_DocForm
          onSubmit={addTipo_Doc}
          initialTipo_Doc={selectedTipo_Doc}
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
              {Tipo_Docs.map((Tipo_Doc) => (
                <TableRow key={Tipo_Doc.id}>
                  <TableCell>{Tipo_Doc.nombre}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editTipo_Doc(Tipo_Doc)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deleteTipo_Doc(Tipo_Doc.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default Tipo_Docs;