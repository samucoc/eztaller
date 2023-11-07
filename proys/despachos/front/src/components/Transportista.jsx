import React, { useState } from 'react';
import QRModal from './QRScanner';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCamera } from '@fortawesome/free-solid-svg-icons';
import './despachos.css'; // Asegúrate de importar tu archivo CSS

const Transportista = () => {
  const [showQRScanner, setShowQRScanner] = useState(false);
  const [action, setAction] = useState(null);

  // Función para abrir el escáner QR
  const handleOpenQRScanner = (actionType) => {
    setAction(actionType);
    setShowQRScanner(true);
  };

  return (
    <div className="centered-container">
      <h3>Escanear Código</h3>
	<br />
	<br />
      	<button onClick={() => handleOpenQRScanner('auto')} className="btn-custom scan-button">
        	<FontAwesomeIcon icon={faCamera} className="icon-custom" />
      	</button>
      {showQRScanner && (
        <QRModal isOpen={showQRScanner} onClose={() => setShowQRScanner(false)} action={action} />
      )}
    </div>
  );
};

export default Transportista;
