import React, { useEffect, useRef } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faPrint } from '@fortawesome/free-solid-svg-icons';
import QRCode from 'qrcode';

function QRCodeModal({ isOpen, onClose, despachoId }) {
  const canvasRef = useRef(null);

  const imprimirCodigoQR = () => {
    const canvas = canvasRef.current;
    const qrCodeImage = canvas.toDataURL('image/png');

    const ventanaImpresion = window.open('', '', 'width=600,height=600');
    ventanaImpresion.document.open();
    ventanaImpresion.document.write('<html><head><title>Modal a Imprimir</title></head><body>');
    ventanaImpresion.document.write('<div style="text-align: center;">');
    ventanaImpresion.document.write('<img src="' + qrCodeImage + '" />');
    ventanaImpresion.document.write('</div>');
    ventanaImpresion.document.write('</body></html>');
    ventanaImpresion.document.close();
    ventanaImpresion.print();
    ventanaImpresion.close();

  };

  useEffect(() => {
    if (isOpen) {
      // Muestra el código QR en el canvas al abrir el modal
      const canvas = canvasRef.current;
      const qrCodeData = String(despachoId);
      QRCode.toCanvas(canvas, qrCodeData, (error) => {
        if (error) {
          console.error('Error al generar el código QR', error);
        }
      });
    }
  }, [isOpen, despachoId]);

  return (
    <div className={`modal ${isOpen ? 'show' : ''}`} tabIndex="-1" role="dialog" style={isOpen ? { display: 'block' } : { display: 'none' }}>
      <div className="modal-dialog" role="document">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">Código QR para Despacho {despachoId}</h5>
            <button type="button" className="close" data-dismiss="modal" aria-label="Close" onClick={onClose}>
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div className="modal-body text-center">
            <canvas ref={canvasRef} id="qrCodeCanvas" />
          </div>
          <div className="modal-footer">
            <button type="button" className="btn btn-secondary" data-dismiss="modal" onClick={onClose}>
              Cerrar
            </button>
            <button type="button" className="btn btn-primary" onClick={imprimirCodigoQR}>
              <FontAwesomeIcon icon={faPrint} /> Imprimir
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default QRCodeModal;
