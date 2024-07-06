import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from './apiConstants'; // Assuming API_BASE_URL is defined here
import EmpresaForm from './EmpresaForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const Empresas = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedEmpresa, setSelectedEmpresa] = useState(null); // State for selected Empresa
  const [Empresas, setEmpresas] = useState([]); // Use state to manage Empresas
  const [comunas, setComunas] = useState([]);

  // Fetch Empresas on component mount
  useEffect(() => {
    const fetchEmpresas = async () => {
      try {
        const response = await axios.get(API_BASE_URL+'/empresas'); // Replace with your API endpoint
        setEmpresas(response.data);
      } catch (error) {
        console.error('Error fetching Empresas:', error);
      }
    };

    fetchEmpresas();

    const obtenerComunas = async () => {
        try {
          const response = await axios.get(API_BASE_URL+'/comunas'); // Reemplaza 'URL_DE_TU_API' con la URL real de tu API
          setComunas(response.data);
        } catch (error) {
          console.error('Error al obtener las comunas:', error);
        }
      };
  
      obtenerComunas();


  }, []);

  const deleteEmpresa = async (id) => {
    try {
      const response = await axios.delete(API_BASE_URL+`/empresas/${id}`); // Delete request with Empresa ID
  
      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setEmpresas(Empresas.filter(Empresa => Empresa.id !== id)); // Filter out deleted Empresa
        console.log('Empresa eliminada exitosamente');
      } else {
        console.error('Error al eliminar la Empresa:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
    }
  };

  const addEmpresa = async (EmpresaData) => {
    try {
        var initialEmpresa = selectedEmpresa
      const url = initialEmpresa ? `${API_BASE_URL}/empresas/${initialEmpresa.id}` : `${API_BASE_URL}/empresas`;
      const method = initialEmpresa ? 'PUT' : 'POST'; // Use PUT for update, POST for create
  
      const response = await axios({
        method,
        url,
        data: EmpresaData,
      });
  
      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedEmpresa = response.data; // Assuming your API returns the updated Empresa
        
        if (initialEmpresa) { // Update scenario, update state with modified Empresa
          setEmpresas(Empresas.map(Empresa => Empresa.id === updatedEmpresa.id ? updatedEmpresa : Empresa));
        } else { // Create scenario, add new Empresa to state
          setEmpresas([...Empresas, updatedEmpresa]);
        }
        
        setShowForm(false); // Hide the form after successful operation
        console.log(initialEmpresa ? 'Empresa actualizada exitosamente' : 'Empresa agregada exitosamente');
      } else {
        console.error(initialEmpresa ? 'Error al actualizar la Empresa:' : 'Error al agregar la Empresa:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialEmpresa ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const editEmpresa = (Empresa) => {
    setSelectedEmpresa(Empresa);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedEmpresa(null);
  };

  return (
    <div className="container Empresas">
      <h3>Empresas</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar Empresa
            </Button>
      </div>
      {showForm ? (
        <EmpresaForm
          onSubmit={addEmpresa}
          initialEmpresa={selectedEmpresa}
          onCancel={handleCancel}
          comunas={comunas} 
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
              {Empresas.map((Empresa) => (
                <TableRow key={Empresa.id}>
                  <TableCell>{Empresa.id}</TableCell>
                  <TableCell>{Empresa.RazonSocial}</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => editEmpresa(Empresa)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deleteEmpresa(Empresa.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default Empresas;