import React, { useState, useEffect } from 'react';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import './despachos.css';
import { Button, Table } from 'react-bootstrap';

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
  

  const handleChange = e => {
    setNuevoCliente({ ...nuevoCliente, [e.target.name]: e.target.value });
  };

  const crearOActualizarCliente = async (e) => {
    e.preventDefault();
  
    try {
      if (nuevoCliente.id) {
        // Si el cliente tiene un ID, actualiza el cliente existente
        await axios.put(API_BASE_URL+`/clientes/${nuevoCliente.id}`, nuevoCliente);
        setNuevoCliente({
          nombreEmpresa: '',
          rutEmpresa: '',
          direccionEmpresa: '',
          nombreContactoEmpresa: '',
          telefonoContactoEmpresa: '',
          correoContactoEmpresa: '',
          nivelEmpresa: ''
        });
      } else {
        // De lo contrario, crea un nuevo cliente
        await axios.post(API_BASE_URL + '/clientes', nuevoCliente);
        setNuevoCliente({
          nombreEmpresa: '',
          rutEmpresa: '',
          direccionEmpresa: '',
          nombreContactoEmpresa: '',
          telefonoContactoEmpresa: '',
          correoContactoEmpresa: '',
          nivelEmpresa: ''
        });
      }
  
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
  };

  return (
    <div className="container">
      <div className="container-fluid"> {/* Si necesitas que ocupe todo el ancho */}
        <div className="row align-items-center p-5">
          <div className="col">
            <h1>Clientes</h1>
          </div>
          <div className="col-auto ml-auto text-right">
            <Button onClick={openModal}>Agregar Cliente</Button>
          </div>
        </div>
      </div>
      <br></br>
      <div className={`modal ${isModalOpen ? 'show' : ''}`} tabIndex="-1" style={{ display: isModalOpen ? 'block' : 'none' }}>
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
                              Nombre Empresa
                            </div>
                            <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Nombre Empresa" name="nombreEmpresa" value={nuevoCliente.nombreEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                              Rut Empresa
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Rut Empresa" name="rutEmpresa" value={nuevoCliente.rutEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                              Dirección Empresa
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Dirección Empresa" name="direccionEmpresa" value={nuevoCliente.direccionEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                          Nombre Contacto Empresa
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Nombre Contacto Empresa" name="nombreContactoEmpresa" value={nuevoCliente.nombreContactoEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                          Teléfono Contacto Empresa
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Teléfono Contacto Empresa" name="telefonoContactoEmpresa" value={nuevoCliente.telefonoContactoEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                          Correo Contacto  Empresa
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Correo Contacto Empresa" name="correoContactoEmpresa" value={nuevoCliente.correoContactoEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                          Nivel Empresa
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Nivel Empresa" name="nivelEmpresa" value={nuevoCliente.nivelEmpresa} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <button className="btn btn-primary" type="submit">Crear</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <Table bordered hover>
        <thead>
          <tr>
            <th>Nro</th>
            <th>Nombre Empresa</th>
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
          {clientes.map(cliente => (
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
                <Button variant="primary" onClick={() => handleEdit(cliente.id)}>Editar</Button>
                <Button variant="danger" onClick={() => handleDelete(cliente.id)}>Eliminar</Button>
              </td>
            </tr>
          ))}
        </tbody>
      </Table>
    </div>
  );
};

export default Clientes;