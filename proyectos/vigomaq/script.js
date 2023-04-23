function checkRutGenerico(campo, isEmpresa){
	var tmpstr = "";
	rut = campo.value;
	for ( i=0; i < rut.length ; i++ )
		if ( rut.charAt(i) != ' ' && rut.charAt(i) != '.' && rut.charAt(i) != '-' )
			tmpstr = tmpstr + rut.charAt(i);
	rut = tmpstr;
	largo = rut.length;
	tmpstr = "";
	for ( i=0; rut.charAt(i) == '0' ; i++ );
		for (; i < rut.length ; i++ )
			tmpstr = tmpstr + rut.charAt(i);
	rut = tmpstr;
	largo = rut.length;
	if ( largo < 2 )	{
		alert("Debe ingresar el RUT completo.");
		campo.focus();
		campo.select();
		return false;
		}
	for (i=0; i < largo ; i++ )	{
		if( (rut.charAt(i) != '0') && (rut.charAt(i) != '1') && (rut.charAt(i) !='2') && (rut.charAt(i) != '3') && (rut.charAt(i) != '4') && (rut.charAt(i) !='5') && (rut.charAt(i) != '6') && (rut.charAt(i) != '7') && (rut.charAt(i) != '8') && (rut.charAt(i) != '9') && (rut.charAt(i) !='k') && (rut.charAt(i) != 'K') ){
			alert("El valor ingresado no corresponde a un RUT valido.");
			campo.focus();
			campo.select();
			return false;
			}
		}
	rutMax = campo.value;
	tmpstr="";
	for ( i=0; i < rutMax.length ; i++ )
		if ( rutMax.charAt(i) != ' ' && rutMax.charAt(i) != '.' && rutMax.charAt(i) != '-' )
			tmpstr = tmpstr + rutMax.charAt(i);
	tmpstr = tmpstr.substring(0, tmpstr.length - 1);
	if ( (!(tmpstr < 50000000)) && (!isEmpresa) ){
		alert('El Rut ingresado no corresponde a un RUT de Persona Natural')
		campo.focus();
		campo.select();
		return false;
		}
	var invertido = "";
	for ( i=(largo-1),j=0; i>=0; i--,j++ )
		invertido = invertido + rut.charAt(i);
	var drut = "";
	drut = drut + invertido.charAt(0);
	drut = drut + '-';
	cnt = 0;
	for ( i=1,j=2; i<largo; i++,j++ ) {
		if ( cnt == 3 ){
			drut = drut + '.';
			j++;
			drut = drut + invertido.charAt(i);
			cnt = 1;
		}
		else {
			drut = drut + invertido.charAt(i);
			cnt++;
			}
		}
	invertido = "";
	for ( i=(drut.length-1),j=0; i>=0; i--,j++ )	{
		if (drut.charAt(i)=='k')
			invertido = invertido + 'K';
		else
			invertido = invertido + drut.charAt(i);
		}
	campo.value = invertido;
	if (!checkDV(rut)) {
		alert("El RUT es incorrecto.");
		campo.focus();
		campo.select();
		return false;
		}
	return true;
	}
	
function checkDV(crut)	{
	largo = crut.length;
	if(largo < 2) {
		return false;
	}
	if(largo > 2){
		rut = crut.substring(0, largo - 1);
	}
	else {
		rut = crut.charAt(0);
	}
	dv = crut.charAt(largo-1);
	if(!checkCDV(dv))	
		return false;
	if(rut == null || dv == null){
		return false;
	}
	var dvr = '0';
	suma = 0;
	mul = 2;
	for (i= rut.length -1 ; i >= 0; i--) {
		suma = suma + rut.charAt(i) * mul;
		if(mul == 7){
			mul = 2;
		}
		else{
			mul++;
		}
	}
	res = suma % 11;
	if (res==1) {
		dvr = 'k';
	}
	else {
		if(res==0){
			dvr = '0';
		}
		else {
			dvi = 11-res;
			dvr = dvi + "";
		}
	}
	if(dvr != dv.toLowerCase()) 	{
		return false;
		}
	return true;
	}
	
function checkCDV(dvr)	{
	dv = dvr + "";
	if(dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k' && dv != 'K'){
		return false;
		}
	return true;
	}

var menu=function(){
	var t=15,z=50,s=6,a;
	function dd(n){this.n=n; this.h=[]; this.c=[]}
	dd.prototype.init=function(p,c){
		a=c; var w=document.getElementById(p), s=w.getElementsByTagName('ul'), l=s.length, i=0;
		for(i;i<l;i++){
			var h=s[i].parentNode; this.h[i]=h; this.c[i]=s[i];
			h.onmouseover=new Function(this.n+'.st('+i+',true)');
			h.onmouseout=new Function(this.n+'.st('+i+')');
		}
	}
	dd.prototype.st=function(x,f){
		var c=this.c[x], h=this.h[x], p=h.getElementsByTagName('a')[0];
		clearInterval(c.t); c.style.overflow='hidden';
		if(f){
			p.className+=' '+a;
			if(!c.mh){c.style.display='block'; c.style.height=''; c.mh=c.offsetHeight; c.style.height=0}
			if(c.mh==c.offsetHeight){c.style.overflow='visible'}
			else{c.style.zIndex=z; z++; c.t=setInterval(function(){sl(c,1)},t)}
		}else{p.className=p.className.replace(a,''); c.t=setInterval(function(){sl(c,-1)},t)}
	}
	function sl(c,f){
		var h=c.offsetHeight;
		if((h<=0&&f!=1)||(h>=c.mh&&f==1)){
			if(f==1){c.style.filter=''; c.style.opacity=1; c.style.overflow='visible'}
			clearInterval(c.t); return
		}
		var d=(f==1)?Math.ceil((c.mh-h)/s):Math.ceil(h/s), o=h/c.mh;
		c.style.opacity=o; c.style.filter='alpha(opacity='+(o*100)+')';
		c.style.height=h+(d*f)+'px'
	}
	return{dd:dd}
}();