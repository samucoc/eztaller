import jsPDF from 'jspdf';
import 'jspdf-autotable';

export const exportToPdf = () => {
  const doc = new jsPDF();
  const tableContent = document.querySelector('.table-container');

  doc.autoTable({ html: tableContent });
  doc.save('responsabilidades.pdf');
};