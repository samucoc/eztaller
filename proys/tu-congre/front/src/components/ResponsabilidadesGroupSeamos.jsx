import React from 'react';
import Responsabilidad from './Responsabilidad';

const ResponsabilidadesGroupSeamos = ({ responsabilidades }) => {
  return (
    <>
      {responsabilidades.map((responsabilidad) => (
        <Responsabilidad key={responsabilidad.id} responsabilidad={responsabilidad} />
      ))}
    </>
  );
};

export default ResponsabilidadesGroupSeamos;