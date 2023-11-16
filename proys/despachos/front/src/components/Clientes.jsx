import React, { useState, useEffect } from 'react';
import ReactHTMLTableToExcel from "react-html-table-to-excel";
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import './despachos.css';
import { Button, Table } from 'react-bootstrap';
import ReactPaginate from 'react-paginate';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faChevronLeft, faChevronRight, faEdit, faTrash } from '@fortawesome/free-solid-svg-icons';

import API_BASE_URL from './apiConstants'; // Import the API_BASE_URL constant

const Clientes = () => {
  const [clientes, setClientes] = useState([]);
  const [nuevoCliente, setNuevoCliente] = useState({
    nombreEmpresa: '',
    rutEmpresa: '',
    direccionEmpresa: '',
    nombreContactoEmpresa: '',
    telefonoContactoEmpresa: '',
    correoContactoEmpresa: '',
    nivelEmpresa: '',
  });

  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 5; // Cambia esto al número deseado de elementos por página

  useEffect(() => {
    cargarClientes();
  }, []);

  const cargarClientes = async () => {
    try {
      const res = await axios.get(API_BASE_URL + '/clientes');
      setClientes(res.data);
    } catch (error) {
      console.error(error);
    }
  };
  
  // Función para manejar el cambio de página
  const handlePageChange = ({ selected }) => {
    setCurrentPage(selected);
  };

  const handleChange = e => {
    setNuevoCliente({ ...nuevoCliente, [e.target.name]: e.target.value });
  };

  // Filtrar los clientes para mostrar solo los de la página actual
  const offset = currentPage * itemsPerPage;
  const displayedClientes = clientes.slice(offset, offset + itemsPerPage);
	
	const crearOActualizarCliente = async (e) => {
	  e.preventDefault();

	  try {
	    if (nuevoCliente.id) {
	      // Si el cliente tiene un ID, actualiza el cliente existente
	      await axios.put(API_BASE_URL+`/clientes/${nuevoCliente.id}`, nuevoCliente);
	    } else {
	      // De lo contrario, crea un nuevo cliente
	      await axios.post(API_BASE_URL + '/clientes', nuevoCliente);
	    }

	    // Restablece el estado de nuevoCliente después de una edición exitosa
	    setNuevoCliente({
		    nombreEmpresa: '',
		    rutEmpresa: '',
		    direccionEmpresa: '',
		    nombreContactoEmpresa: '',
		    telefonoContactoEmpresa: '',
		    correoContactoEmpresa: '',
		    nivelEmpresa: '',
	    });

	    // Carga nuevamente los clientes y cierra el modal después de crear o actualizar
	    cargarClientes();
	    closeModal();
	  } catch (error) {
	    console.error(error);
	  }
	};
  
  const [isModalOpen, setIsModalOpen] = useState(false);

  const openModal = () => {
    setIsModalOpen(true);
  }

  const openModal2 = () => {
      setNuevoCliente({
        nombreEmpresa: '',
        rutEmpresa: '',
        direccionEmpresa: '',
        nombreContactoEmpresa: '',
        telefonoContactoEmpresa: '',
        correoContactoEmpresa: '',
        nivelEmpresa: ''
      });
    setIsModalOpen(true);
  }
  
  const closeModal = () => {
    setIsModalOpen(false);
  }

  const handleEdit = async (id) => {
    const clienteSeleccionado = clientes.find(cliente => cliente.id === id);
    if (clienteSeleccionado) {
      setNuevoCliente({...clienteSeleccionado});
      openModal();
    }
  };
  
	const handleDelete = async (id) => {
	  const confirmDelete = window.confirm("¿Estás seguro de que deseas eliminar este cliente?");

	  if (confirmDelete) {
	    try {
	      await axios.delete(API_BASE_URL+`/clientes/${id}`);
	      setNuevoCliente({
	        nombreEmpresa: '',
	        rutEmpresa: '',
	        direccionEmpresa: '',
	        nombreContactoEmpresa: '',
	        telefonoContactoEmpresa: '',
	        correoContactoEmpresa: '',
	        nivelEmpresa: ''
	      });
	      cargarClientes(); // carga nuevamente los clientes después de eliminar
	    } catch (error) {
	      console.error(error);
	    }
	  }
	};   


  return (
    <div className="container">
      <div className="container-fluid"> {/* Si necesitas que ocupe todo el ancho */}
        <div className="row align-items-center p-5">
          <div className="col">
            <h1>Clientes</h1>
          </div>
          <div className="col-auto ml-auto text-right">
            <Button onClick={openModal2} className="btn-custom">Agregar Cliente</Button>
            {/* Botón para exportar la tabla a Excel */}
            <ReactHTMLTableToExcel
              id="botonExportar"
              className="btn btn-custom"
              table="miTabla"
              filename="mi_tabla_excel"
              sheet="Sheet"
              buttonText="Exportar a Excel"
            />
          </div>
        </div>
      </div>
      <br></br>
      <div className={`modal ${isModalOpen ? 'show' : ''} modal-negro`} tabIndex="-1" style={{ display: isModalOpen ? 'block' : 'none' }}>
          <div className="modal-dialog">
              <div className="modal-content">
                 <div className="modal-header">
                    <h5 className="modal-title" id="modalLabel">Agregar Cliente</h5>
                    <button type="button" className="close" data-dismiss="modal"  onClick={closeModal} aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div className="modal-body">
                      <form onSubmit={crearOActualizarCliente}>
                          <div className="row">
                            <div className="col-3">
                              Nombre
                            </div>
                            <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Nombre" name="nombreEmpresa" value={nuevoCliente.nombreEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                              Rut
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Rut" name="rutEmpresa" value={nuevoCliente.rutEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                              Dirección
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Dirección" name="direccionEmpresa" value={nuevoCliente.direccionEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                          Nombre Contacto
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Nombre Contacto" name="nombreContactoEmpresa" value={nuevoCliente.nombreContactoEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                          Teléfono Contacto
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Teléfono Contacto" name="telefonoContactoEmpresa" value={nuevoCliente.telefonoContactoEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                          Correo Contacto 
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Correo Contacto" name="correoContactoEmpresa" value={nuevoCliente.correoContactoEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                          Nivel
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Nivel" name="nivelEmpresa" value={nuevoCliente.nivelEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <button className="btn-custom" type="submit">Crear</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <Table bordered hover className="miTabla" id="miTabla">
        <thead>
          <tr>
            <th>Nro</th>
            <th>Nombre</th>
            <th>RUT/DNI</th>
            <th>Dirección</th>
            <th>Nombre de Contacto</th>
            <th>Teléfono de Contacto</th>
            <th>Correo de Contacto</th>
            <th>Nivel</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {displayedClientes.map(cliente => (
            <tr key={cliente.id}>
              <td>{cliente.id}</td>
              <td>{cliente.nombreEmpresa}</td>
              <td>{cliente.rutEmpresa}</td>
              <td>{cliente.direccionEmpresa}</td>
              <td>{cliente.nombreContactoEmpresa}</td>
              <td>{cliente.telefonoContactoEmpresa}</td>
              <td>{cliente.correoContactoEmpresa}</td>
              <td>{cliente.nivelEmpresa}</td>
              <td>
                <Button variant="primary" onClick={() => handleEdit(cliente.id)} className="btn-custom">
			<FontAwesomeIcon icon={faEdit} />
		</Button>
                <Button variant="danger" onClick={() => handleDelete(cliente.id)} className="btn-custom">
			<FontAwesomeIcon icon={faTrash} />
		</Button>
              </td>
            </tr>
          ))}
        </tbody>
      </Table>
      {/* Agregar la paginación */}
      <ReactPaginate
        previousLabel={<FontAwesomeIcon icon={faChevronLeft} />}
        nextLabel={<FontAwesomeIcon icon={faChevronRight} />}
        breakLabel={'...'}
        pageCount={Math.ceil(clientes.length / itemsPerPage)}
        marginPagesDisplayed={2}
        pageRangeDisplayed={5}
        onPageChange={handlePageChange}
        containerClassName={'pagination'}
        activeClassName={'active'}
	previousLinkClassName="btn-custom"
	nextLinkClassName="btn-custom"
      />
    </div>
  );
};

export default Clientes;
