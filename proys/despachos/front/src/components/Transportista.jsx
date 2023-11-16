import React, { useState } from 'react';
import QRModal from './QRScanner';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCamera } from '@fortawesome/free-solid-svg-icons';
import './despachos.css'; // Asegúrate de importar tu archivo CSS
import 'bootstrap/dist/css/bootstrap.css';
import Button from 'react-bootstrap/Button';

const Transportista = () => {
  const [showQRScanner, setShowQRScanner] = useState(false);
  const [action, setAction] = useState(null);
  const [nombre, setNombre] = useState(null);
  const [rut, setRut] = useState(null);

  // Función para abrir el escáner QR
  const handleOpenQRScanner = (actionType) => {
    setAction(actionType);
    setShowQRScanner(true);
    setNombre(document.getElementById('nombre').value);
    setRut(document.getElementById('rut').value);
  };

  const username = localStorage.getItem('username');

  return (
    <div className="centered-container">
      <h3>Escanear Código</h3>
      <br />
      <br />
      <Button
        onClick={() => {
          handleOpenQRScanner('auto');
        }}
        className="btn-custom scan-button"
      >
        <FontAwesomeIcon icon={faCamera} className="icon-custom" />
      </Button>
      <br />
      <input type="text" className="form-control" name="nombre" id="nombre"/>
      <br />
      <input type="text" className="form-control" name="rut" id="rut"/>
      <span className="nav-link mr-3" style={{ color: 'white' }}>{username}</span>
      {showQRScanner && (
        <QRModal
          isOpen={showQRScanner}
          action={action}
          nombre={nombre}
          rut={rut}
          onClose={() => setShowQRScanner(false)}
        />
      )}
    </div>
  );
};

export default Transportista;
