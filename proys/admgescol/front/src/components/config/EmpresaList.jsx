import React, { useEffect } from 'react';

const EmpresaList = ({ empresas, empresaId, handleSelectChange }) => {
  return (
    <div className="container mt-5">
      <div className="row justify-content-center">
        <div className="col-md-6">
          <div className="card">
            <div className="card-body">
              <h2 className="card-title text-center mb-4">Seleccione una empresa</h2>
              <div className="mb-3">
                <label htmlFor="empresaSelect" className="form-label">Empresa</label>
                <select
                  id="empresaSelect"
                  className="form-select"
                  value={empresaId}
                  onChange={(e) => handleSelectChange(e.target.value)}
                >
                  <option value="">Seleccionar empresa</option>
                  {empresas.map(empresa => (
                    <option key={empresa.id} value={empresa.id}>{empresa.RazonSocial}</option>
                  ))}
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default EmpresaList;
