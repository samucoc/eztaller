import React, { useState, useEffect } from 'react';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';
import './despachos.css';
import Button from 'react-bootstrap/Button';
import Table from 'react-bootstrap/Table';
import  QRModal  from './QRScanner'; 
import  QRCodeModal  from './QRCodeModal';

import API_BASE_URL from './apiConstants'; // Import the API_BASE_URL constant


const Despachos = () => {
  const [Despachos, setDespachos] = useState([]);
  const [clientes, setClientes] = useState([]);
  const [conductores, setConductores] = useState([]);
  const [vehiculos, setVehiculos] = useState([]);
  const [showQRModal, setShowQRModal] = useState(false);

  const [nuevoDespacho, setNuevoDespacho] = useState({
    fecha: '',
    cliente_id: '',
    origenDespacho: '',
    destinoDespacho: '',
    conductor_id: '',
    vehiculo_id: '',
  });

  const handleShowQRModal = (despachoId) => {
    setSelectedDespachoId(despachoId);
    setShowQRModal(true);
  };

  const handleCloseQRModal = () => {
    setShowQRModal(false);
  };
  const [showQRScanner, setShowQRScanner] = useState(false);
  const [selectedDespachoId, setSelectedDespachoId] = useState(null);
  const [action, setAction] = useState(null); // recoger o entregar

  const handleShow = (despachoId, actionType) => {
    setSelectedDespachoId(despachoId);
    setAction(actionType);
    setShowQRScanner(true);
};

  const handleClose = () => {
    setShowQRScanner(false);
    setSelectedDespachoId(null);
  }

  useEffect(() => {
    cargarDespachos();
    cargarClientes();
    cargarConductores();
    cargarVehiculos();
    console.log(showQRScanner);
  }, [showQRScanner]);

  const cargarClientes = async () => {
    const res = await axios.get(API_BASE_URL + '/clientes');
    setClientes(res.data);
  };

  const cargarConductores = async () => {
    const res = await axios.get(API_BASE_URL + '/conductores');
    setConductores(res.data);
  };

  const cargarVehiculos = async () => {
    const res = await axios.get(API_BASE_URL + '/vehiculos');
    setVehiculos(res.data);
  };

  const cargarDespachos = async () => {
    try {
      const res = await axios.get(API_BASE_URL + '/despachos');
      setDespachos(res.data);
    } catch (error) {
      console.error(error);
    }
  };
  

  const handleChange = e => {
    setNuevoDespacho({ ...nuevoDespacho, [e.target.name]: e.target.value });
  };

  const crearOActualizarDespacho = async (e) => {
    e.preventDefault();
  
    try {
      if (nuevoDespacho.id) {
        // Si el Despacho tiene un ID, actualiza el Despacho existente
        await axios.put(API_BASE_URL + `/despachos/${nuevoDespacho.id}`, nuevoDespacho);
        setNuevoDespacho({
          fecha: '',
          cliente_id: '',
          origenDespacho: '',
          destinoDespacho: '',
          conductor_id: '',
          vehiculo_id: '',
        });
      } else {
        // De lo contrario, crea un nuevo Despacho
        await axios.post(API_BASE_URL + '/despachos', nuevoDespacho);
        setNuevoDespacho({
          fecha: '',
          cliente_id: '',
          origenDespacho: '',
          destinoDespacho: '',
          conductor_id: '',
          vehiculo_id: '',
        });
      }
  
      // Carga nuevamente los Despachos y cierra el modal después de crear o actualizar
      cargarDespachos();
      closeModal();
    } catch (error) {
      console.error(error);
    }
  };
  
  const [isModalOpen, setIsModalOpen] = useState(false);

  const openModal = () => setIsModalOpen(true);
  const closeModal = () => setIsModalOpen(false);

  const handleEdit = async (id) => {
    const Despachoseleccionado = Despachos.find(Despacho => Despacho.id === id);
    if (Despachoseleccionado) {
      setNuevoDespacho({...Despachoseleccionado});
      openModal();
    }
  };
  
  const handleDelete = async (id) => {
    try {
      await axios.delete(API_BASE_URL + `/despachos/${id}`);
      setNuevoDespacho({
        fecha: '',
        cliente_id: '',
        origenDespacho: '',
        destinoDespacho: '',
        conductor_id: '',
        vehiculo_id: '',
      });
      cargarDespachos(); // carga nuevamente los Despachos después de eliminar
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div className="container">
      <div className="container-fluid"> {/* Si necesitas que ocupe todo el ancho */}
        <div className="row align-items-center p-5">
          <div className="col">
            <h1>Despachos</h1>
          </div>
          <div className="col-auto ml-auto text-right">
            <Button onClick={openModal}>Agregar Despacho</Button>
          </div>
        </div>
      </div>
      <br></br>
      <div className={`modal ${isModalOpen ? 'show' : ''}`} tabIndex="-1" role="dialog" style={{ display: isModalOpen ? 'block' : 'none' }}>
        <div className="modal-dialog" role="document">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title">Agregar Despacho</h5>
              <button type="button" className="close" onClick={closeModal}>
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div className="modal-body">
              <form onSubmit={crearOActualizarDespacho}>
                <div className="form-group">
                  <input
                    type="date"
                    className="form-control"
                    placeholder="Fecha Despacho"
                    name="fecha"
                    value={nuevoDespacho.fecha}
                    onChange={handleChange}
                  />
                </div>

                <div className="form-group">
                  <select 
                    className="form-control"
                    name="cliente_id"
                    value={nuevoDespacho.cliente_id}
                    onChange={handleChange}
                  >
                    <option>Seleccione...</option>
                    {clientes.map(cliente => (
                      <option key={cliente.id} value={cliente.id}>{cliente.nombreEmpresa}</option>
                    ))}
                  </select>
                </div>

                <div className="form-group">
                  <input
                    type="text"
                    className="form-control"
                    placeholder="Origen Despacho"
                    name="origenDespacho"
                    value={nuevoDespacho.origenDespacho}
                    onChange={handleChange}
                  />
                </div>

                <div className="form-group">
                  <input
                    type="text"
                    className="form-control"
                    placeholder="Destino Despacho"
                    name="destinoDespacho"
                    value={nuevoDespacho.destinoDespacho}
                    onChange={handleChange}
                  />
                </div>

                <div className="form-group">
                  <select 
                    className="form-control"
                    name="conductor_id"
                    value={nuevoDespacho.conductor_id}
                    onChange={handleChange}
                  >
                    <option>Seleccione...</option>
                    {conductores.map(conductor => (
                      <option key={conductor.id} value={conductor.id}>{conductor.nombres} {conductor.apellidoPaterno} </option>
                    ))}
                  </select>
                </div>

                <div className="form-group">
                  <select 
                    className="form-control"
                    name="vehiculo_id"
                    value={nuevoDespacho.vehiculo_id}
                    onChange={handleChange}
                  >
                    <option>Seleccione...</option>
                    {vehiculos.map(vehiculo => (
                      <option key={vehiculo.id} value={vehiculo.id}>{vehiculo.patente}</option>
                    ))}
                  </select>
                </div>

                <button className="btn btn-primary" type="submit">
                  Crear
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <Table bordered hover>
        <thead>
          <tr>
            <th>Nro Orden</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Conductor</th>
            <th>Vehiculo</th>
            <th>Estado Recogido</th>
            <th>Estado Entregado</th>
            <th>QR</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        {Despachos.map(Despacho => {
        // Encuentra el cliente, el conductor y el vehículo correspondiente
        return (
          <tr key={Despacho.id}>
            <td>{Despacho.id}</td>
            <td>{formatDateMin(Despacho.fecha)}</td>
            <td>{Despacho.cliente_id}</td>
            <td>{Despacho.origenDespacho}</td>
            <td>{Despacho.destinoDespacho}</td>
            <td>{Despacho.conductor_id}</td>            
            <td>{Despacho.vehiculo_id}</td>
            <td>
              {formatDate(Despacho.recogido) != null
                ? formatDate(Despacho.recogido)
                : <Button variant="warning" onClick={() => handleShow(Despacho.id, "recoger")}>Camara</Button> }
            </td>
            <td>
              {formatDate(Despacho.recogido) == null
                ? '' : formatDate(Despacho.entregado) != null ?
                formatDate(Despacho.entregado) 
                : <Button variant="warning" onClick={() => handleShow(Despacho.id, "entregar")}>Camara</Button> }
            </td>
            <td><Button variant="info" onClick={() => handleShowQRModal(Despacho.id)}>Ver</Button></td>
            <td>
              <Button variant="primary" onClick={() => handleEdit(Despacho.id)}>Editar</Button>
              <Button variant="danger" onClick={() => handleDelete(Despacho.id)}>Eliminar</Button>
            </td>
          </tr>
        );
      })}
        </tbody>
      </Table>
      <QRModal isOpen={showQRScanner} onClose={handleClose} despachoId={selectedDespachoId} action={action} />
      <QRCodeModal 
        isOpen={showQRModal} 
        onClose={handleCloseQRModal} 
        despachoId={selectedDespachoId} 
      />
  </div>
  );
};

function formatDate(string) {
  if (string!=null){
    const date = new Date(string);
    const dd = String(date.getDate()).padStart(2, '0');
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const yyyy = date.getFullYear();
    const hh = String(date.getHours()).padStart(2, '0');
    const ii = String(date.getMinutes()).padStart(2, '0');
    const ss = String(date.getSeconds()).padStart(2, '0');
  
    return `${dd}-${mm}-${yyyy} ${hh}:${ii}:${ss}`;
  }
}

function formatDateMin(string) {
  const date = new Date(string);
  const dd = String(date.getDate()).padStart(2, '0');
  const mm = String(date.getMonth() + 1).padStart(2, '0');
  const yyyy = date.getFullYear();
  return `${dd}-${mm}-${yyyy}`;
}

export default Despachos;