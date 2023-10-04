import React, { useState } from 'react';
import  QRModal  from './QRScanner'; 
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faChevronLeft, faChevronRight, faCamera, faEdit, faTrash } from '@fortawesome/free-solid-svg-icons';

const Transportista = () => {
  const [showQRScanner, setShowQRScanner] = useState(false);
  const [action, setAction] = useState(null);

  // Función para abrir el escáner QR
  const handleOpenQRScanner = (actionType) => {
    setAction(actionType);
    setShowQRScanner(true);
  };

  return (
    <div>
      <h3>Escanear Código</h3>
      <button onClick={() => handleOpenQRScanner('auto')}><FontAwesomeIcon icon={faCamera} /></button>
      {showQRScanner && (
        <QRModal isOpen={showQRScanner} onClose={() => setShowQRScanner(false)} action={action} />
      )}
    </div>
  );
};

export default Transportista;