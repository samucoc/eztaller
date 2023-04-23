// LIBRERIA DE VALIDACIONES  JavaScript PROTIC INGENIEROS //
// Última Actualizacion 23.02.2008                        // 

function RecorrerForm(){
var sStr = "";
var formulario = document.forms['Form1'];
for (i=0;i<formulario.elements.length;i++)
{
sAux += "NOMBRE: " + formulario.elements[i].name;
sAux += "TIPO : " + formulario.elements[i].type;
sAux += "VALOR: " + formulario.elements[i].value + "\n" ;
}
alert(sStr);
}
