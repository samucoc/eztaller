import React from 'react';

const Responsabilidad = ({ responsabilidad }) => {
  return (
    <div class='row'>
      <div class="col-1">{responsabilidad.tiempo}</div>
      <div class="col-7">{responsabilidad.nombre}</div>
      <div class="col-1">{responsabilidad.sala_1.persona_1}</div>
      <div class="col-1">{responsabilidad.sala_1.persona_2}</div>
      <div class="col-1">{responsabilidad.sala_2.persona_1}</div>
      <div class="col-1">{responsabilidad.sala_2.persona_2}</div>
    </div>
  );
};

export default Responsabilidad;