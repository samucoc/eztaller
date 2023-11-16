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
  const [nombre, setNombre] = useState('');
  const [rut, setRut] = useState('');
  const [rutError, setRutError] = useState(null);

  // Función para abrir el escáner QR
  const handleOpenQRScanner = (actionType) => {
    // Validar que nombre y rut estén ingresados
    if (!nombre.trim() || !rut.trim()) {
      alert('Por favor, complete los campos de nombre y rut.');
      return;
    }

    // Validar el rut chileno
    if (!validarRut(rut)) {
      setRutError('El rut ingresado no es válido.');
      return;
    } else {
      setRutError(null);
    }

    setAction(actionType);
    setShowQRScanner(true);
  };

  const validarRut = (rut) =>  {
    // Formato: 12345678-9 o 12.345.678-9
    const rutRegex = /^(\d{1,3}(\.\d{3}){0,2}|\d{1,3})(-)?(\d|k|K)$/;
  
    if (!rutRegex.test(rut)) {
      return false;
    }
  
    // Limpiar el Rut y extraer el dígito verificador
    const cleanRut = rut.replace(/[^\dkK]/g, '');
    const rutDigits = cleanRut.slice(0, -1);
    const verificador = cleanRut.slice(-1).toLowerCase();
  
    // Calcular el dígito verificador esperado
    let suma = 0;
    let multiplicador = 2;
  
    for (let i = rutDigits.length - 1; i >= 0; i--) {
      suma += parseInt(rutDigits[i]) * multiplicador;
      multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }
  
    const resto = suma % 11;
    const dvEsperado = resto === 0 ? 0 : 11 - resto;
  
    // Verificar el dígito verificador
    return (verificador === 'k' && dvEsperado === 10) || (parseInt(verificador) === dvEsperado);
  }

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
      <div className="row">
        <div className="col-12 mb-3 ml-3">
          <input
            type="text"
            className="form-control text-center"
            placeholder="Nombre Completo"
            name="nombre"
            id="nombre"
            value={nombre}
            onChange={(e) => setNombre(e.target.value)}
          />
          <br />
        </div>
        <div className="col-12 mb-3 ml-3">
          <input
            type="text"
            className={`form-control text-center ${rutError ? 'is-invalid' : ''}`}
            placeholder="Rut"
            name="rut"
            id="rut"
            value={rut}
            onChange={(e) => setRut(e.target.value)}
          />
          {rutError && <div className="invalid-feedback">{rutError}</div>}
        </div>
      </div>
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
