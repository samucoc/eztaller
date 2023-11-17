import React, { useState, useEffect, useRef } from 'react';
import ReactHTMLTableToExcel from "react-html-table-to-excel";
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';
import './despachos.css';
import Button from 'react-bootstrap/Button';
import Table from 'react-bootstrap/Table';
import  QRModal  from './QRScanner'; 
import  QRCodeModal  from './QRCodeModal';
import ReactPaginate from 'react-paginate';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faChevronLeft, faChevronRight, faCamera, faEdit, faTrash, faPrint } from '@fortawesome/free-solid-svg-icons';
import QRCode from 'qrcode';

import API_BASE_URL from './apiConstants'; // Import the API_BASE_URL constant


const Despachos = () => {
  const [Despachos, setDespachos] = useState([]);
  const [clientes, setClientes] = useState([]);
  const [conductores, setConductores] = useState([]);
  const [vehiculos, setVehiculos] = useState([]);
  const [showQRModal, setShowQRModal] = useState(false);

  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 5; // Cambia esto al número deseado de elementos por página

  const [nuevoDespacho, setNuevoDespacho] = useState({
    fecha: '',
    cliente_id: '',
    origenDespacho: '',
    destinoDespacho: '',
    conductor_id: '',
    vehiculo_id: '',
    estado_1:'',        
    estado_2:'',        
    estado_3:'',        
    estado_4:'',
    estado_5:'',
    nombreEmpresa:'',
    nombre_conductor:'',
    patente:'',	
    });

    const canvasRef = useRef(null);

    const imprimirCodigoQR = (despachoId) => {
      const qrCodeData = String(despachoId);
    
      // Generar la URL del código QR de manera asíncrona
      QRCode.toDataURL(qrCodeData, (error, qrCodeUrl) => {
        if (error) {
          console.error('Error al generar el código QR', error);
          return;
        }
    
        // Encontrar el despacho correspondiente
        const Despachoseleccionado = Despachos.find((Despacho) => Despacho.id === despachoId);
    
        // Abrir la ventana de impresión
        const ventanaImpresion = window.open('', '', 'width=800,height=600');
        ventanaImpresion.document.open();
        ventanaImpresion.document.write('<html><head><title>Despacho</title>');
        ventanaImpresion.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">');
        ventanaImpresion.document.write('</head><body>');
        ventanaImpresion.document.write('<div class="row" style="border: 2px solid #000000; width:80%; text-align: center;">');
        ventanaImpresion.document.write('<div class="col-6 p-3" style="border: 2px solid #000000">');
        
        // Asegurarse de que el despacho existe antes de intentar acceder a sus propiedades
        if (Despachoseleccionado) {
          ventanaImpresion.document.write('<div class="row p-3">'+Despachoseleccionado.fecha+'</div>');
          ventanaImpresion.document.write('<div class="row p-3">'+Despachoseleccionado.nombreEmpresa+'</div>');
          ventanaImpresion.document.write('<div class="row p-3">'+Despachoseleccionado.origenDespacho+'</div>');
          ventanaImpresion.document.write('<div class="row p-3">'+Despachoseleccionado.destinoDespacho+'</div>');
          ventanaImpresion.document.write('<div class="row p-3">'+Despachoseleccionado.nombre_conductor+'</div>');
          ventanaImpresion.document.write('<div class="row p-3">'+Despachoseleccionado.patente+'</div>');
        }
        ventanaImpresion.document.write('</div>');
        ventanaImpresion.document.write('<div class="col-6 p-3" style="border: 2px solid #0000000; text-align: center;">');
        
        // Mostrar la imagen QR generada
        ventanaImpresion.document.write('<img src="' + qrCodeUrl + '" width="400"/>');
        ventanaImpresion.document.write('</div');
        ventanaImpresion.document.write('</div');
        ventanaImpresion.document.write('</body></html>');
        ventanaImpresion.document.close();
    
        // Esperar a que la imagen se cargue antes de imprimir
        ventanaImpresion.onload = () => {
          ventanaImpresion.print();
          ventanaImpresion.close();
        };
      });
    };


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

  // Función para manejar el cambio de página
  const handlePageChange = ({ selected }) => {
    setCurrentPage(selected);
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


  // Filtrar los clientes para mostrar solo los de la página actual
  const offset = currentPage * itemsPerPage;
  const displayedClientes = Despachos.slice(offset, offset + itemsPerPage);


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
        estado_1:'',        
        estado_2:'',
        estado_3:'',
        estado_4:'',
        estado_5:'',
        nombreEmpresa:'',
        nombre_conductor:'',
        patente:'',   
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
        estado_1:'',        
        estado_2:'',
        estado_3:'',
        estado_4:'',
        estado_5:'',
        nombreEmpresa:'',
        nombre_conductor:'',
        patente:'',   
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

  const [isModalEstadosOpen, setisModalEstadosOpen] = useState(false);

  const openEstadosDespachos = () => setisModalEstadosOpen(true);
  const closeEstadosDespachos = () => setisModalEstadosOpen(false);

  const handleEdit = async (id) => {
    const Despachoseleccionado = Despachos.find(Despacho => Despacho.id === id);
    if (Despachoseleccionado) {
      setNuevoDespacho({...Despachoseleccionado});
      openModal();
    }
  };

	const handleEstadosDespachos = async (id) => {
	  setNuevoDespacho({
	    fecha: '',
	    cliente_id: '',
	    origenDespacho: '',
	    destinoDespacho: '',
	    conductor_id: '',
	    vehiculo_id: '',
	    estado_1: '', // Inicializar en vacío
	    estado_2: '', // Inicializar en vacío
	    estado_3: '', // Inicializar en vacío
	    estado_4: '', // Inicializar en vacío
	    estado_5: '', // Inicializar en vacío
	    nombreEmpresa: '',
	    nombre_conductor: '',
	    patente: '',
	  });

	  const Despachoseleccionado = Despachos.find(Despacho => Despacho.id === id);
	  if (Despachoseleccionado) {
	    setNuevoDespacho({...Despachoseleccionado});
	    openEstadosDespachos();
	  }
	};

  const handleDelete = async (id) => {
	  const confirmDelete = window.confirm("¿Estás seguro de que deseas eliminar este registro?");

	  if (confirmDelete) {
		    try {
		      await axios.delete(API_BASE_URL + `/despachos/${id}`);
		      setNuevoDespacho({
		        fecha: '',
		        cliente_id: '',
		        origenDespacho: '',
		        destinoDespacho: '',
		        conductor_id: '',
		        vehiculo_id: '',
		        estado_1:'',        
		        estado_2:'',
		        estado_3:'',
		        estado_4:'',
		        estado_5:'',
		        nombreEmpresa:'',
		        nombre_conductor:'',
		        patente:'',
		      });
		      cargarDespachos(); // carga nuevamente los Despachos después de eliminar
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
            <h1>Despachos</h1>
          </div>
          <div className="col-auto ml-auto text-right">
            <Button onClick={openModal} className="btn-custom">Agregar Despacho</Button>
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
      <div className={`modal ${isModalEstadosOpen ? 'show' : ''} modal-negro`} tabIndex="-1" role="dialog" style={{ display: isModalEstadosOpen ? 'block' : 'none' }}>
        <div className="modal-dialog" role="document">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Ver Estados Despacho</h5>
                <button type="button" className="close" onClick={closeEstadosDespachos}>
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div className="modal-body">
                <div className="row">
                  <div className="col-3">
                    Fecha Despacho
                  </div>
                  <div className="form-group col-9">
	                  <input
        	            type="date"
                	    className="form-control"
	                    placeholder="Fecha Despacho"
        	            name="fecha"
                	    value={nuevoDespacho.fecha}
	                    onChange={handleChange}
        	          />
                	</div>
		            </div>
		            <br/>
                <div className="row">
                  <div className="col-3">
                          Cliente	
                  </div>
	                <div className="form-group col-9">
	                  <select 
	                    className="form-control"
	                    name="cliente_id"
	                    value={nuevoDespacho.cliente_id}
	                    onChange={handleChange}
	                  >
	                    <option>Seleccione...</option>
	                    {clientes.map(cliente => (
	                      <option 
                          key={cliente.id} 
                          value={cliente.id} 
                          selected={nuevoDespacho.cliente_id === cliente.id} >
                        {cliente.nombreEmpresa}
                            </option>
	                    ))}
	                  </select>
	                </div>
		            </div>
		            <br/>
                <div className="row">
                  <div className="col-3">
                          Estado 1	
                  </div>
	                <div className="form-group col-9">
                          <input
                            type="text"
                            className="form-control"
                            placeholder="Estado 1"
                            name="fecha"
                            value={nuevoDespacho.estado_1}
                          />
	                </div>
		            </div>
		            <br/>
                <div className="row">
                  <div className="col-3">
                          Estado 2	
                  </div>
	                <div className="form-group col-9">
	                  <input
                            type="text"
                            className="form-control"
                            placeholder="Estado 2"
                            name="fecha"
                            value={nuevoDespacho.estado_2}
                          />
	                </div>
		            </div>
		            <br/>
                <div className="row">
                  <div className="col-3">
                          Estado 3	
                  </div>
	                <div className="form-group col-9">
	                  <input
                            type="text"
                            className="form-control"
                            placeholder="Estado 3"
                            name="fecha"
                            value={nuevoDespacho.estado_3}
                          />
	                </div>
		            </div>
		            <br/>
                <div className="row">
                  <div className="col-3">
                          Estado 4	
                  </div>
	                <div className="form-group col-9">
	                  <input
                            type="text"
                            className="form-control"
                            placeholder="Estado 4"
                            name="fecha"
                            value={nuevoDespacho.estado_4}
                          />
	                </div>
		            </div>
		            <br/>
                <div className="row">
                  <div className="col-3">
                          Estado 5	
                  </div>
	                <div className="form-group col-9">
                          <input
                            type="texte"
                            className="form-control"
                            placeholder="Estado 5"
                            name="fecha"
                            value={nuevoDespacho.estado_5}
                          />
	                </div>
		            </div>
		            <br/>
                <div className="row">
                        <div className="col-3">
                                Conductor
                        </div>
	                <div className="form-group col-9">
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
		            </div>
                <br/>
		            <div className="row">
                  <div className="col-3">
                          Vehículo
                  </div>
	                <div className="form-group col-9">
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
		            </div>
              </div>
            </div>
        </div>
      </div>

      <div className={`modal ${isModalOpen ? 'show' : ''} modal-negro`} tabIndex="-1" role="dialog" style={{ display: isModalOpen ? 'block' : 'none' }}>
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
                <div className="row">
                  <div className="col-3">
                    Fecha Despacho
                  </div>
                  <div className="form-group col-9">
	                  <input
        	            type="date"
                	    className="form-control"
	                    placeholder="Fecha Despacho"
        	            name="fecha"
                	    value={nuevoDespacho.fecha}
	                    onChange={handleChange}
        	          />
                	</div>
		            </div>
		            <br/>
                <div className="row">
                        <div className="col-3">
                                Cliente	
                        </div>
	                <div className="form-group col-9">
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
		            </div>
		            <br/>
                <div className="row">
                        <div className="col-3">
                                Origen Despacho
                        </div>
    	                <div className="form-group col-9">
	                  <input
	                    type="text"
	                    className="form-control"
	                    placeholder="Origen Despacho"
	                    name="origenDespacho"
	                    value={nuevoDespacho.origenDespacho}
	                    onChange={handleChange}
	                  />
	                </div>
		            </div>
                <br/>
		              <div className="row">
                        <div className="col-3">
                                Destino Despacho
                        </div>
	                <div className="form-group col-9">
	                  <input
	                    type="text"
	                    className="form-control"
	                    placeholder="Destino Despacho"
	                    name="destinoDespacho"
	                    value={nuevoDespacho.destinoDespacho}
	                    onChange={handleChange}
	                  />
	                </div>
		            </div>
                <br/>
		            <div className="row">
                        <div className="col-3">
                                Conductor
                        </div>
	                <div className="form-group col-9">
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
		            </div>
                <br/>
		              <div className="row">
                        <div className="col-3">
                                Vehículo
                        </div>
	                <div className="form-group col-9">
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
		            </div>
		            <button className="btn-custom" type="submit">
                  Crear
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <Table bordered hover className="miTabla" id="miTabla">
        <thead>
          <tr>
            <th>Nro Orden</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Conductor</th>
            <th>Vehiculo</th>
            <th>Estados</th>
            <th>QR</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        {displayedClientes.map(Despacho => {
        // Encuentra el cliente, el conductor y el vehículo correspondiente
        return (
          <tr key={Despacho.id}>
            <td>{Despacho.id}</td>
            <td>{formatDateMin(Despacho.fecha)}</td>
            <td>{Despacho.nombreEmpresa}</td>
            <td>{Despacho.origenDespacho}</td>
            <td>{Despacho.destinoDespacho}</td>
            <td>{Despacho.nombre_conductor}</td>            
            <td>{Despacho.patente}</td>
            <td><Button variant="info" onClick={() => handleEstadosDespachos(Despacho.id) } className="btn-custom">Ver</Button></td>
            <td><Button variant="info" onClick={() => handleShowQRModal(Despacho.id)} className="btn-custom">Ver</Button></td>
            <td>
              <Button variant="primary" onClick={() => handleEdit(Despacho.id)} className="btn-custom">
                <FontAwesomeIcon icon={faEdit} />
              </Button>
              <Button variant="danger" onClick={() => handleDelete(Despacho.id)} className="btn-custom">
                <FontAwesomeIcon icon={faTrash} />
              </Button>
              <Button variant="info" onClick={() => imprimirCodigoQR(Despacho.id)} className="btn-custom">
                <FontAwesomeIcon icon={faPrint} />
              </Button>
              <div className="modal-body text-center hide">
                <canvas ref={canvasRef} id="qrCodeCanvas" />
              </div>
            </td>
          </tr>
        );
      })}
        </tbody>
      </Table>
      <ReactPaginate
        previousLabel={<FontAwesomeIcon icon={faChevronLeft} />}
        nextLabel={<FontAwesomeIcon icon={faChevronRight} />}
        breakLabel={'...'}
        pageCount={Math.ceil(Despachos.length / itemsPerPage)}
        marginPagesDisplayed={2}
        pageRangeDisplayed={5}
        onPageChange={handlePageChange}
        containerClassName={'pagination'}
        activeClassName={'active'}
        previousLinkClassName="btn-custom"
        nextLinkClassName="btn-custom"
      />
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
