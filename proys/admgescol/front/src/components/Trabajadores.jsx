import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from './apiConstants'; // Assuming API_BASE_URL is defined here
import TrabajadorForm from './TrabajadorForm';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@material-ui/core'; // Importa componentes de Material-UI
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import swal from 'sweetalert2';

const Trabajadores = ({empresaId}) => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedtrabajador, setSelectedtrabajador] = useState(null);
  const [Trabajadores, setTrabajadores] = useState([]); // Use state to manage Trabajadores

  // Fetch Trabajadores on component mount
  useEffect(() => {
    const fetchTrabajadores = async () => {
      try {
        const response = empresaId == '' ? await axios.get(API_BASE_URL+'/trabajadores') : await axios.get(API_BASE_URL+'/trabajadores/showByEmpresa/'+empresaId) ; // Replace with your API endpoint
        setTrabajadores(response.data);
      } catch (error) {
        console.error('Error fetching Trabajadores:', error);
      }
    };
    // Verificar si selectedtrabajador no es null antes de ejecutar setShowForm(true)
    if (selectedtrabajador !== null) {
      console.log(selectedtrabajador);
      setShowForm(true);
    }
    
    fetchTrabajadores();
  }, [selectedtrabajador]);

  const deletetrabajador = async (id) => {
    try {
      const response = await axios.delete(API_BASE_URL+`/trabajadores/${id}`); // Delete request with trabajador ID
  
      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setTrabajadores(Trabajadores.filter(trabajador => trabajador.id !== id)); // Filter out deleted trabajador
        console.log('trabajador eliminada exitosamente');
      } else {
        console.error('Error al eliminar la trabajador:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
    }
  };  

  const validateRUT = (rut) => {
    if (!/^[0-9]+-[0-9kK]{1}$/.test(rut)) {
      return false;
    }
  
    const [rutBody, dv] = rut.split('-');
    const formattedDV = dv.toLowerCase() === 'k' ? 'k' : dv;
  
    let sum = 0;
    let multiplier = 2;
  
    for (let i = rutBody.length - 1; i >= 0; i--) {
      sum += parseInt(rutBody[i], 10) * multiplier;
      multiplier = (multiplier === 7) ? 2 : multiplier + 1;
    }
  
    const calculatedDV = 11 - (sum % 11);
    const validDV = calculatedDV === 11 ? '0' : calculatedDV === 10 ? 'k' : calculatedDV.toString();
  
    return validDV === formattedDV;
  };
  

  const addtrabajador = async (trabajadorData) => {
    try {
      var initialTrabajador = selectedtrabajador

      const rutCompleto = `${trabajadorData.rut}-${trabajadorData.dv}`;
      if (validateRUT(rutCompleto)) {
        const url = initialTrabajador ? `${API_BASE_URL}/trabajadores/${initialTrabajador.id}` : `${API_BASE_URL}/trabajadores`;
        const method = initialTrabajador ? 'PUT' : 'POST'; // Use PUT for update, POST for create

        const formData = new FormData();

        formData.append('id', trabajadorData.id)
        formData.append('empresa_id', trabajadorData.empresa_id)
        formData.append('user_id', trabajadorData.user_id)
        formData.append('rut', trabajadorData.rut)
        formData.append('dv', trabajadorData.dv)
        formData.append('apellido_paterno', trabajadorData.apellido_paterno)
        formData.append('apellido_materno', trabajadorData.apellido_materno)
        formData.append('nombres', trabajadorData.nombres)
        formData.append('nombre_social', trabajadorData.nombre_social)
        formData.append('fecha_nac', trabajadorData.fecha_nac) 
        formData.append('nacionalidad', trabajadorData.nacionalidad)
        formData.append('cargo_id', trabajadorData.cargo_id)
        formData.append('sexo_id', trabajadorData.sexo_id)
        formData.append('direccion', trabajadorData.direccion)
        formData.append('comuna_id', trabajadorData.comuna_id)
        formData.append('telefono', trabajadorData.telefono)
        formData.append('email', trabajadorData.email)
        formData.append('contacto_emergencia', trabajadorData.contacto_emergencia)
        formData.append('telefono_emergencia', trabajadorData.telefono_emergencia)
        formData.append('estado_id', trabajadorData.estado_id)
        const data = Object.fromEntries(formData); // Convert formData to object

        const response = await axios({
          method,
          url,
          data: JSON.stringify(data)
        });

        const updatedtrabajador = response.data; // Assuming your API returns the updated trabajador
      
        // Handle file upload (before or in parallel with resource update)
        if (trabajadorData.foto && updatedtrabajador.id) {
          const formData1 = new FormData();
          formData1.append('foto', trabajadorData.foto)

          const fileUploadResponse = await axios({
            method: 'POST',
            url: `${API_BASE_URL}/trabajadores/uploadFoto/${updatedtrabajador.id}`,
            data: formData1,
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          });
        }

        if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
          if (initialTrabajador) { // Update scenario, update state with modified trabajador
            setTrabajadores(Trabajadores.map(trabajador => trabajador.id === updatedtrabajador.id ? updatedtrabajador : trabajador));
          } else { // Create scenario, add new trabajador to state
            setTrabajadores([...Trabajadores, updatedtrabajador]);
          }
          setShowForm(false); // Hide the form after successful operation
          console.log(initialTrabajador ? 'trabajador actualizada exitosamente' : 'trabajador agregada exitosamente');
        } else {
          console.error(initialTrabajador ? 'Error al actualizar la trabajador:' : 'Error al agregar la trabajador:', response.data); // Handle creation/update errors
        }
      } else {
        swal.fire("Error", "El dígito verificador no corresponde al RUT ingresado.", "error");
      }

    } catch (error) {
      console.error(initialTrabajador ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
    }
  };

  const edittrabajador = (trabajador) => {
    setSelectedtrabajador(trabajador);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedtrabajador(null);
  };

  return (
    <div className="container Trabajadores">
      <h3>Trabajadores</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => setShowForm(true)}
            >
            Agregar trabajador
            </Button>
      </div>
      {showForm ? (
        <TrabajadorForm
          onSubmit={addtrabajador}
          initialTrabajador={selectedtrabajador}
          onCancel={handleCancel}
          empresaId={empresaId}
        />
      ) : (
        <TableContainer component={Paper}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>Rut</TableCell>
                <TableCell>Nombre Completo</TableCell>
                <TableCell>Email</TableCell>
                <TableCell>Estado</TableCell>
                <TableCell>Acciones</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {Trabajadores
                .map((trabajador) => (
                <TableRow key={trabajador.id}>
                  <TableCell>{trabajador.rut}-{trabajador.dv}</TableCell>
                  <TableCell>{trabajador.nombres} {trabajador.apellido_paterno} {trabajador.apellido_materno}</TableCell>
                  <TableCell>{trabajador.email}</TableCell>
                  <TableCell>{trabajador.estado_id == "1" ? "Activo" : "Inactivo" }</TableCell>
                  <TableCell>
                    <Button variant="contained" color="primary" onClick={() => edittrabajador(trabajador)} startIcon={<EditIcon />}>Editar</Button>
                    <Button variant="contained" color="secondary" onClick={() => deletetrabajador(trabajador.id)} startIcon={<DeleteIcon />}>Eliminar</Button>
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

export default Trabajadores;
