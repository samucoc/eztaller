import React, { useState, useEffect } from 'react';
import ReactHTMLTableToExcel from "react-html-table-to-excel";
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import './despachos.css';
import { Button, Table } from 'react-bootstrap';

import API_BASE_URL from './apiConstants'; // Import the API_BASE_URL constant

const Vehiculos = () => {
  const [Vehiculos, setVehiculos] = useState([]);
  const [nuevoVehiculo, setNuevoVehiculo] = useState({
    nombre: '',
    patente: '',
    año: '',
    marca: '',
    modelo: '',
    tipo: '',
  });

  useEffect(() => {
    cargarVehiculos();
  }, []);

  const cargarVehiculos = async () => {
    try {
      const res = await axios.get(API_BASE_URL + '/vehiculos');
      setVehiculos(res.data);
    } catch (error) {
      console.error(error);
    }
  };
  

  const handleChange = e => {
    setNuevoVehiculo({ ...nuevoVehiculo, [e.target.name]: e.target.value });
  };

  const crearOActualizarVehiculo = async (e) => {
    e.preventDefault();
  
    try {
      if (nuevoVehiculo.id) {
        // Si el Vehiculo tiene un ID, actualiza el Vehiculo existente
        await axios.put(API_BASE_URL+`/vehiculos/${nuevoVehiculo.id}`, nuevoVehiculo);
        setNuevoVehiculo({
          nombre: '',
          patente: '',
          año: '',
          marca: '',
          modelo: '',
          tipo: '',
        });
      } else {
        // De lo contrario, crea un nuevo Vehiculo
        await axios.post(API_BASE_URL + '/vehiculos', nuevoVehiculo);
        setNuevoVehiculo({
          nombre: '',
          patente: '',
          año: '',
          marca: '',
          modelo: '',
          tipo: '',
        });
      }
  
      // Carga nuevamente los Vehiculos y cierra el modal después de crear o actualizar
      cargarVehiculos();
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
    const Vehiculoseleccionado = Vehiculos.find(Vehiculo => Vehiculo.id === id);
    if (Vehiculoseleccionado) {
      setNuevoVehiculo({...Vehiculoseleccionado});
      openModal();
    }
  };
  
  const handleDelete = async (id) => {
    try {
      await axios.delete(API_BASE_URL+`/vehiculos/${id}`);
      setNuevoVehiculo({
        nombre: '',
        patente: '',
        año: '',
        marca: '',
        modelo: '',
        tipo: '',
      });
      cargarVehiculos(); // carga nuevamente los Vehiculos después de eliminar
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div className="container">
      <div className="container-fluid"> {/* Si necesitas que ocupe todo el ancho */}
        <div className="row align-items-center p-5">
          <div className="col">
            <h1>Vehiculos</h1>
          </div>
          <div className="col-auto ml-auto text-right">
            <Button onClick={openModal} className="btn-custom">Agregar Vehiculo</Button>
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
                    <h5 className="modal-title" id="modalLabel">Agregar Vehiculo</h5>
                    <button type="button" className="close" data-dismiss="modal"  onClick={closeModal} aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div className="modal-body">
                      <form onSubmit={crearOActualizarVehiculo}>
                          <div className="row">
                            <div className="col-3">
                              Nombre
                            </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="nombre" name="nombre" value={nuevoVehiculo.nombre} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                              Patente
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="patente" name="patente" value={nuevoVehiculo.patente} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                                Año
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Año" name="año" value={nuevoVehiculo.año} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                                Marca
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Marca" name="marca" value={nuevoVehiculo.marca} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                                Modelo
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="date" className="form-control" placeholder="Modelo" name="modelo" value={nuevoVehiculo.modelo} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                              Tipo
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Tipo" name="tipo" value={nuevoVehiculo.tipo} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <button className="btn btn-primary" type="submit">Crear</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <Table bordered hover style={{ color: '#EBA51C', backgroundColor: '#242526' }} className="miTabla">
        <thead>
          <tr>
            <th>Nro</th>
            <th>Nombre</th>
            <th>Patente</th>
            <th>Año</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Tipo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {Vehiculos.map(Vehiculo => (
            <tr key={Vehiculo.id}>
              <td>{Vehiculo.id}</td>
              <td>{Vehiculo.nombre}</td>
              <td>{Vehiculo.patente}</td>
              <td>{Vehiculo.año}</td>
              <td>{Vehiculo.marca}</td>
              <td>{Vehiculo.modelo}</td>
              <td>{Vehiculo.tipo}</td>
              <td>
                <Button variant="primary" onClick={() => handleEdit(Vehiculo.id)} className="btn-custom">Editar</Button>
                <Button variant="danger" onClick={() => handleDelete(Vehiculo.id)} className="btn-custom">Eliminar</Button>
              </td>
            </tr>
          ))}
        </tbody>
      </Table>
    </div>
  );
};

export default Vehiculos;
