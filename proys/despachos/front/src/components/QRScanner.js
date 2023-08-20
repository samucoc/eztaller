import React, { useState, useRef, useEffect } from 'react';
import axios from 'axios';

import jsQR from 'jsqr';
import API_BASE_URL from './apiConstants'; // Import the API_BASE_URL constant

function QRModal({ isOpen, onClose, despachoId, action}) {
  const [Despachos, setDespachos] = useState([]);

  const videoRef = useRef(null);
  const [qrCodeResult, setQrCodeResult] = useState(null);

  useEffect(() => {
    if (!isOpen) {
      return;
    }

    const video = videoRef.current;

    navigator.mediaDevices
      .getUserMedia({ video: { facingMode: "environment" } })
      .then((stream) => {
        video.srcObject = stream;
        video.play();

        const canvas = document.createElement('canvas');
        canvas.width = video.clientWidth;
        canvas.height = video.clientHeight;

        const ctx = canvas.getContext('2d');

        const scanQR = () => {
          ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
          const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
          const code = jsQR(imageData.data, imageData.width, imageData.height);
          if (code) {
            setQrCodeResult(code.data);
            // Extraer acción y ID del QR

            let response;
            if (action === "recoger") {
                fetchRecogerDespacho(despachoId);
            } else if (action === "entregar") {
                fetchEntregarDespacho(despachoId);
            } else {
                console.error("Acción no válida.");
                return;
            }

            onClose();  // Cerrar modal
            // Aquí asumimos que tienes una función que refresca los datos de la tabla
            cargarDespachos();
            
          } else {
            requestAnimationFrame(scanQR);
          }
        };
        scanQR();
      })
      .catch((err) => {
        console.error("Error accessing camera: ", err);
      });

    return () => {
      if (video && video.srcObject) {
        video.srcObject.getTracks().forEach(track => track.stop());
      }
    };
  }, [isOpen]);

  const fetchRecogerDespacho = async (idDespacho) => {
    try {
        const response = await axios.get(API_BASE_URL + '/despachos/recoger/'+idDespacho, {
            headers: {
                'Content-Type': 'application/json',
            },
        });

        console.log(response.data);
        // Hacer algo con la respuesta

    } catch (error) {
        console.error('Error:', error);
    }
}

const fetchEntregarDespacho = async (idDespacho) => {
  try {
      const response = await axios.get(API_BASE_URL + '/despachos/entregar/'+idDespacho, {
          headers: {
              'Content-Type': 'application/json',
          },
      });

      console.log(response.data);
      // Hacer algo con la respuesta

  } catch (error) {
      console.error('Error:', error);
  }
}

  const cargarDespachos = async () => {
    try {
      const res = await axios.get(API_BASE_URL + '/despachos');
      setDespachos(res.data);
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div className={`modal ${isOpen ? 'show' : ''}`} tabIndex="-1" role="dialog" style={isOpen ? { display: 'block' } : { display: 'none' }}>
      <div className="modal-dialog" role="document">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">QR Scanner</h5>
            <button type="button" className="close" onClick={onClose} aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div className="modal-body">
            <video ref={videoRef} width="300" height="300"></video>
            <p>Resultado: {qrCodeResult}</p>
          </div>
          <div className="modal-footer">
            <button type="button" className="btn btn-secondary" onClick={onClose}>Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default QRModal;
