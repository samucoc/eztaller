import React, { useRef, useState, useEffect } from 'react';
import axios from 'axios';
import ResponsabilidadesGroupSeamos from './ResponsabilidadesGroupSeamos';
import ResponsabilidadesGroupTesoros from './ResponsabilidadesGroupTesoros';
import ResponsabilidadesGroupVidaMinisterio from './ResponsabilidadesGroupVidaMinisterio';
import { API_BASE_URL } from './apiConstants';
import 'bootstrap/dist/css/bootstrap.min.css';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
import { jsPDF } from 'jspdf';
import html2canvas from 'html2canvas';



pdfMake.vfs = pdfFonts.pdfMake.vfs;

const Salas = () => {
  const currentDate = new Date();
  const currentYear = currentDate.getFullYear();
  const currentMonth = currentDate.getMonth() + 1;
  const [responsabilidadesSeamos, setResponsabilidadesSeamos] = useState([]);
  const [responsabilidadesTesoros, setResponsabilidadesTesoros] = useState([]);
  const [responsabilidadesVidaMinisterio, setResponsabilidadesVidaMinisterio] = useState([]);
  const [selectedYear, setSelectedYear] = useState(currentYear);
  const [selectedMonth, setSelectedMonth] = useState(currentMonth);



  const years = [
    { value: 2020, label: '2020' },
    { value: 2021, label: '2021' },
    { value: 2022, label: '2022' },
    { value: 2023, label: '2023' },
  ];

  const months = [
    { value: 1, label: 'Enero' },
    { value: 2, label: 'Febrero' },
    { value: 3, label: 'Marzo' },
    { value: 4, label: 'Abril' },
    { value: 5, label: 'Mayo' },
    { value: 6, label: 'Junio' },
    { value: 7, label: 'Julio' },
    { value: 8, label: 'Agosto' },
    { value: 9, label: 'Septiembre' },
    { value: 10, label: 'Octubre' },
    { value: 11, label: 'Noviembre' },
    { value: 12, label: 'Diciembre' },
  ];

  const handleYearChange = (e) => {
    setSelectedYear(parseInt(e.target.value));
  };

  const handleMonthChange = (e) => {
    setSelectedMonth(parseInt(e.target.value));
  };

  useEffect(() => {
    fetchData();
  }, [selectedYear, selectedMonth]);

  const fetchData = async () => {
    const responseSeamos = await axios.get(`${API_BASE_URL}/calendarizacion?tipo=1&year=${selectedYear}&month=${selectedMonth}`);
    const responseTesoros = await axios.get(`${API_BASE_URL}/calendarizacion?tipo=2&year=${selectedYear}&month=${selectedMonth}`);
    const responseVidaMinisterio = await axios.get(`${API_BASE_URL}/calendarizacion?tipo=3&year=${selectedYear}&month=${selectedMonth}`);

    setResponsabilidadesSeamos(responseSeamos.data);
    setResponsabilidadesTesoros(responseTesoros.data);
    setResponsabilidadesVidaMinisterio(responseVidaMinisterio.data);
  };
  

  const responsabilidadesRef = useRef(null);

  const responsabilidadesToHTML = () => {
    let html = '<div class="row">';
  
    // Combina las responsabilidades en un solo array
    const allResponsabilidades = [...responsabilidadesSeamos,...responsabilidadesTesoros,...responsabilidadesVidaMinisterio];
  
    allResponsabilidades.forEach((responsabilidad) => {
      html += `
        <div class="row">
          <div class="col-1">${responsabilidad.tiempo}</div>
          <div class="col-7">${responsabilidad.nombre}</div>
          <div class="col-1">${responsabilidad.sala_1.persona_1}</div>
          <div class="col-1">${responsabilidad.sala_1.persona_2}</div>
          <div class="col-1">${responsabilidad.sala_2.persona_1}</div>
          <div class="col-1">${responsabilidad.sala_2.persona_2}</div>
        </div>`;
    });
  
    html += '</div>';
  
    return html;
  };

  const exportToPdf = async () => {
    const pdf = new jsPDF('p', 'pt', 'a4');
    const html = responsabilidadesToHTML();
    const canvas = await html2canvas(html);
    const imgData = canvas.toDataURL('image/png');
    const imgProps = pdf.getImageProperties(imgData);
    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
  
    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
    pdf.save('responsabilidades.pdf');
  };

  const exportToWord = () => {
    const html = `
      <html>
        <head>
          <meta charset="utf-8">
          <style>
            .row { display: flex; }
            .col { flex: 1; }
          </style>
        </head>
        <body>
          ${responsabilidadesToHTML()}
        </body>
      </html>`;
  
    const blob = new Blob(['\ufeff', html], {
      type: 'application/msword',
    });
  
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
  
    link.href = url;
    link.download = 'responsabilidades.doc';
    link.click();
  
    setTimeout(() => {
      URL.revokeObjectURL(url);
    }, 100);
  };

  return (
    <div className="container">
      <div className="row">
        <div className="col">
          <label htmlFor="yearSelect">Año:</label>
          <select
            className="form-select"
            id="yearSelect"
            value={selectedYear}
            onChange={handleYearChange}
          >
            {years.map((year) => (
              <option key={year.value} value={year.value}>
                {year.label}
              </option>
            ))}
          </select>
        </div>

        <div className="col">
          <label htmlFor="monthSelect">Mes:</label>
          <select
            className="form-select"
            id="monthSelect"
            value={selectedMonth}
            onChange={handleMonthChange}
          >
            {months.map((month) => (
              <option key={month.value} value={month.value}>
                {month.label}
              </option>
            ))}
          </select>
        </div>
      </div>
      {/* Aquí se muestran los componentes ResponsabilidadesGroup */}
      <div ref={responsabilidadesRef} className="row mt-4">
        <ResponsabilidadesGroupSeamos responsabilidades={responsabilidadesSeamos} />
        <ResponsabilidadesGroupTesoros responsabilidades={responsabilidadesTesoros} />
        <ResponsabilidadesGroupVidaMinisterio responsabilidades={responsabilidadesVidaMinisterio} />
      </div>
      <div className="row mt-4">
        <div class="col-6">
          <button className="btn btn-primary" onClick={exportToPdf}>
            Exportar a PDF
          </button>
        </div>
        <div class="col-6">
          <button className="btn btn-secondary ml-2" onClick={exportToWord}>
            Exportar a Word
          </button>
        </div>
      </div>
    </div>
  );
};




export default Salas;