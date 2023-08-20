import React from 'react';
import  QRCode  from 'qrcode.react';

function QRCodeModal({ isOpen, onClose, despachoId }) {
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
                    <QRCode value={String(despachoId)} size={256} />
                </div>
                <div className="modal-footer">
                    <button type="button" className="btn btn-secondary" data-dismiss="modal" onClick={onClose}>Cerrar</button>
                </div>
            </div>
        </div>
    </div>

  );
}

export default QRCodeModal;
