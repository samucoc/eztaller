var nav4 = window.Event ? true : false;
function SoloNumeros(field, evt, salta){ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	var key = nav4 ? evt.which : evt.keyCode; 
	if (key == 13) {
	var i;
	for (i = 0; i <field.form.elements.length; i++)
	if (field == field.form.elements[i])
	break;
	i = salta + (i + 1) % field.form.elements.length;
	field.form.elements[i].focus();
	return false;
	}
	else
	return (key <= 13 || (key >= 48 && key <= 57));
}
function Tabula(field, evt, salta){ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	var key = nav4 ? evt.which : evt.keyCode; 
	if (key == 13) {
	var i;
	for (i = 0; i <field.form.elements.length; i++)
	if (field == field.form.elements[i])
	break;
	i = salta + (i + 1) % field.form.elements.length;
	field.form.elements[i].focus();
	return false;
	}
	else
	return true;
}

function getKeyCode(e){
e= (window.event)? event : e;
intKey = (e.keyCode)? e.keyCode: e.charCode;
return intKey; 
}

function ValidaFormulario(funcion_xajax){

	var mensaje = '';
	for (i=0;i<document.Form1.elements.length;i++){
		if(document.Form1.elements[i].type != 'button'){
			document.Form1.elements[i].className='';
		}
	}
	
	for (i=0;i<document.Form1.elements.length;i++){
		
		if(document.Form1.elements[i].type != 'button'){
			if( (document.Form1.elements[i].type == 'text') || (document.Form1.elements[i].type == 'textarea') || (document.Form1.elements[i].type == 'password') ){
				mensaje = 'Aviso: No puede dejar este campo vacio';
				if ((document.Form1.elements[i].value.length==0) && (document.Form1.elements[i].name.substr(0,4) == 'OBLI')){
					document.Form1.elements[i].focus();
					document.Form1.elements[i].className='tabla-alycar-input-yellow';
					alert(mensaje);
					return 0;
				}
			}
			if(document.Form1.elements[i].type == 'select-one'){
				mensaje = 'Aviso: No puede dejar este campo sin seleccionar';
				if ((document.Form1.elements[i].value=='- - Seleccione - -') && (document.Form1.elements[i].name.substr(0,4) == 'OBLI')){
					document.Form1.elements[i].focus();
					document.Form1.elements[i].className='tabla-alycar-input-yellow';
					alert(mensaje);
					return 0;
				}
			}
		}
	}
	if (funcion_xajax != ''){
		xajax_GrabaPaso(xajax.getFormValues('Form1'));
	}
	
}

function ValidaFormularioMantenedor(){

	var mensaje = '';
	for (i=0;i<document.Form1.elements.length;i++){
		if(document.Form1.elements[i].type != 'button'){
			document.Form1.elements[i].className='';
		}
	}
	
	for (i=0;i<document.Form1.elements.length;i++){
		
		if(document.Form1.elements[i].type != 'button'){
			if( (document.Form1.elements[i].type == 'text') || (document.Form1.elements[i].type == 'textarea') || (document.Form1.elements[i].type == 'password') ){
				mensaje = 'Aviso: No puede dejar este campo vacio';
				if ((document.Form1.elements[i].value.length==0) && (document.Form1.elements[i].name.substr(0,4) == 'OBLI')){
					document.Form1.elements[i].focus();
					document.Form1.elements[i].className='tabla-alycar-input-yellow';
					alert(mensaje);
					//document.Form1.elements[i].className='text-peq';
					return 0;
				}
			}
			if(document.Form1.elements[i].type == 'select-one'){
				mensaje = 'Aviso: No puede dejar este campo sin seleccionar';
				if ((document.Form1.elements[i].value=='- - Seleccione - -') && (document.Form1.elements[i].name.substr(0,4) == 'OBLI')){
					document.Form1.elements[i].focus();
					document.Form1.elements[i].className='tabla-alycar-input-yellow';
					alert(mensaje);
					return 0;
				}
			}
		}
	}
	
	xajax_Grabar(xajax.getFormValues('Form1'));
	
}
