import React, { useState, useEffect } from 'react';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import './despachos.css';
import { Button, Table } from 'react-bootstrap';

import API_BASE_URL from './apiConstants'; // Import the API_BASE_URL constant

const Conductores = () => {
  const [Conductores, setConductores] = useState([]);
  const [nuevoConductor, setNuevoConductor] = useState({
    rut: '',
    nombres: '',
    apellidoPaterno: '',
    apellidoMaterno: '',
    fechaNacimiento: '',
    direccion: '',
    email: '',
    licenciaConducir: ''
  });

  useEffect(() => {
    cargarConductores();
  }, []);

  const cargarConductores = async () => {
    try {
      const res = await axios.get(API_BASE_URL + '/conductores');
      setConductores(res.data);
    } catch (error) {
      console.error(error);
    }
  };
  

  const handleChange = e => {
    setNuevoConductor({ ...nuevoConductor, [e.target.name]: e.target.value });
  };

  const crearOActualizarConductor = async (e) => {
    e.preventDefault();
  
    try {
      if (nuevoConductor.id) {
        // Si el Conductor tiene un ID, actualiza el Conductor existente
        await axios.put(API_BASE_URL+`/conductores/${nuevoConductor.id}`, nuevoConductor);
        setNuevoConductor({
          rut: '',
          nombres: '',
          apellidoPaterno: '',
          apellidoMaterno: '',
          fechaNacimiento: '',
          direccion: '',
          email: '',
          licenciaConducir: ''
        });
      } else {
        // De lo contrario, crea un nuevo Conductor
        await axios.post(API_BASE_URL + '/conductores', nuevoConductor);
        setNuevoConductor({
          rut: '',
          nombres: '',
          apellidoPaterno: '',
          apellidoMaterno: '',
          fechaNacimiento: '',
          direccion: '',
          email: '',
          licenciaConducir: ''
        });
      }
  
      // Carga nuevamente los Conductores y cierra el modal después de crear o actualizar
      cargarConductores();
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
    const Conductoreseleccionado = Conductores.find(Conductor => Conductor.id === id);
    if (Conductoreseleccionado) {
      setNuevoConductor({...Conductoreseleccionado});
      openModal();
    }
  };
  
  const handleDelete = async (id) => {
    try {
      await axios.delete(API_BASE_URL+`/conductores/${id}`);
      setNuevoConductor({
        rut: '',
        nombres: '',
        apellidoPaterno: '',
        apellidoMaterno: '',
        fechaNacimiento: '',
        direccion: '',
        email: '',
        licenciaConducir: ''
      });
      cargarConductores(); // carga nuevamente los Conductores después de eliminar
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div className="container">
      <div className="container-fluid"> {/* Si necesitas que ocupe todo el ancho */}
        <div className="row align-items-center p-5">
          <div className="col">
            <h1>Conductores</h1>
          </div>
          <div className="col-auto ml-auto text-right">
            <Button onClick={openModal}>Agregar Conductor</Button>
          </div>
        </div>
      </div>
      <br></br>
      <div className={`modal ${isModalOpen ? 'show' : ''}`} tabIndex="-1" style={{ display: isModalOpen ? 'block' : 'none' }}>
          <div className="modal-dialog">
              <div className="modal-content">
                 <div className="modal-header">
                    <h5 className="modal-title" id="modalLabel">Agregar Conductor</h5>
                    <button type="button" className="close" data-dismiss="modal"  onClick={closeModal} aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div className="modal-body">
                      <form onSubmit={crearOActualizarConductor}>
                          <div className="row">
                            <div className="col-3">
                              Rut
                            </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Rut" name="rut" value={nuevoConductor.rut} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                              Nombres
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Nombres" name="nombres" value={nuevoConductor.nombres} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                                Apellido Paterno
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Apellido Paterno" name="apellidoPaterno" value={nuevoConductor.apellidoPaterno} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                                Apellido Materno
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Apellido Materno" name="apellidoMaterno" value={nuevoConductor.apellidoMaterno} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                              <div className="col-3">
                                Fecha Nacimiento
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="date" className="form-control" placeholder=" Fecha Nacimiento" name="fechaNacimiento" value={nuevoConductor.fechaNacimiento} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                          <div className="col-3">
                              Dirección
                              </div>
                              <div className="col-9">
                                  <div className="mb-3">
                                      <input type="text" className="form-control" placeholder="Direccion" name="direccion" value={nuevoConductor.direccion} onChange={handleChange} />
                                  </div>
                              </div>
                          </div>
                          <div className="row">
                                <div className="col-3">
                                Email
                                </div>
                                <div className="col-9">
                                    <div className="mb-3">
                                        <input type="text" className="form-control" placeholder="Email" name="email" value={nuevoConductor.email} onChange={handleChange} />
                                </div>
                            </div>
                          </div>
                          <div className="row">
                                <div className="col-3">
                                  Licencia Conducir
                                </div>
                                <div className="col-9">
                                    <div className="mb-3">
                                        <input type="text" className="form-control" placeholder="Licencia Conducir" name="licenciaConducir" value={nuevoConductor.licenciaConducir} onChange={handleChange} />
                                </div>
                            </div>
                          </div>
                          <button className="btn btn-primary" type="submit">Crear</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <Table bordered hover className="miTabla">
        <thead>
          <tr>
            <th>Nro</th>
            <th>Rut</th>
            <th>Nombres</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Fecha Nacimiento</th>
            <th>Dirección</th>
            <th>Email</th>
            <th>Licencia Conducir</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {Conductores.map(Conductor => (
            <tr key={Conductor.id}>
              <td>{Conductor.id}</td>
              <td>{Conductor.rut}</td>
              <td>{Conductor.nombres}</td>
              <td>{Conductor.apellidoPaterno}</td>
              <td>{Conductor.apellidoMaterno}</td>
              <td>{Conductor.fechaNacimiento}</td>
              <td>{Conductor.direccion}</td>
              <td>{Conductor.email}</td>
              <td>{Conductor.licenciaConducir}</td>
              <td>
                <Button variant="primary" onClick={() => handleEdit(Conductor.id)}>Editar</Button>
                <Button variant="danger" onClick={() => handleDelete(Conductor.id)}>Eliminar</Button>
              </td>
            </tr>
          ))}
        </tbody>
      </Table>
    </div>
  );
};

export default Conductores;
