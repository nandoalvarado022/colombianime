<head>
<meta charset="UTF-8">
<title>Feria Inmobiliaria</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>	
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="shortcut icon" href="http://especiales.elheraldo.co/feria-inmobiliaria/images/favicon.ico">
</head>
<style type="text/css">
@import url(https://fonts.googleapis.com/css?family=Dosis:400,300,500,700);
body{
	margin: 0px;
}
.principal-container{
	width: 100%;
    background: url("http://especiales.elheraldo.co/feria-inmobiliaria/images/fondo-bienvenida3.jpg") no-repeat center center;
}
.container{
	width: 1000px;
	margin: 0 auto;
	padding-top: 30px;
	padding-bottom: 40px;
}
.header-texto{
	font-family: 'Dosis', sans-serif;
}
.header-texto h2{
	font-size: 30px;
	color: #fff;
	font-weight: 100;
}
.header-texto p{
	color: #d9f521;
	font-size: 25px;
}
.logo{
	background: url("http://especiales.elheraldo.co/feria-inmobiliaria/images/logo-feriainmobiliaria.png") 0px 0px no-repeat;
	height: 163px;
	width: 530px;
}
.logo-footer{
	background: url("http://especiales.elheraldo.co/feria-inmobiliaria/images/footer-feria-inmobiliaria.png") 0px 0px no-repeat;
	height: 207px;
	width: 100%;
	background-size: 1000px;
}
.footer{
	width: 100%;
	margin-top: 0px;
}
.footer .info-footer{
	width: 1000px;
	margin: 0 auto;
	text-align: center;
	position: relative;
    top: -50px;
}
.terms{
	color: #fff;
    font-family: 'Dosis', sans-serif;
    font-size: 14px;
    text-decoration: underline;
    letter-spacing: 0.18px;
}
.footer .info-footer h2{
	color: #9E9C9C;
	font-family: 'Dosis', sans-serif;
	font-size: 25px;
    font-weight: 100;
	border-bottom: 1px solid #EAEAEA;
	padding-bottom: 20px;
}
#btnSubmit{
	opacity: 0.7;
	cursor: not-allowed;
}
#counter{
	width: 500px;
}
.formbox-editor-599739 {margin: 0 auto;padding: 0px 40px;text-align: left;width: 790px;box-sizing: border-box;position: relative;top: -50px;}
.formbox-editor-599739 fieldset {border: none;margin: 0;padding: 0;position: relative;float: left;}
.formbox-editor-599739 fieldset > input, .formbox-editor fieldset > textarea, .formbox-editable-field {margin: 10px 0;outline: none;}
.formbox-title-599739 {background: none;border: none;color: #000;font-family: Helvetica, Arial, sans-serif;font-size: 20px;padding: 0;width: 1000px;word-break: break-all;margin: 10px 0;}
.formbox-title-599739 {border-radius: 0;min-height: 0;}
input.formbox-field-599739 {border: 2px solid #f1f2f2;border-radius: 0;box-sizing: border-box;color: #000;font-family: Helvetica, Arial, sans-serif;font-size: 14px;padding: 15px;width: 573px;}
input.field-error-599739 {border-color: #f15858;}
input.formbox-button-599739 {background-color: #ed1c24 !important;border-width: 0;border-style: solid;border-color: #ed1c24 !important;border-radius: 8px;color: #fff;display: inline-block;font-family: Helvetica, Arial, sans-serif;font-size: 14px;font-weight: 600;padding: 17px;margin: 10px 0;text-align: center;word-break: break-all;cursor: pointer;}
.formbox-title-599739{font-family:Helvetica,Arial,sans-serif !important;font-size:20px !important;color:#000000 !important;text-align:left !important;}
.formbox-button-599739{font-family:Helvetica,Arial,sans-serif !important;font-size:14px !important;font-weight:600 !important;color:#ffffff !important;background-color:#21292d !important;border-radius:2px !important;border-color:#21292d !important;border-width:0px !important;border-style:solid;}
 #tdLogo599739 img{margin-botton:10px; max-width:230px;}

 @media screen and (max-width: 480px) {
 	.container{
 		width: 320px;
 		padding-bottom: 150px;
 	}
 	.logo{
		height: 100px;
		width: 100%;
		background-size: 320px;
 	}
 	#counter{
 		padding: 0px 10px;
 		width: 320px;
 	}
 	.footer .info-footer{
 		width: 320px;
 	}
 	.logo-footer{
 		background-size: 320px;
 		background: url("http://especiales.elheraldo.co/feria-inmobiliaria/images/footer-feria-inmobiliaria-movil.png") 0px 0px no-repeat;
 		height: 628px;
 	}
 	.container .formbox-editor-599739{
 		width: 320px;
 		top: 0px;
 		padding: 0px;
 	}
 	.container input.formbox-field-599739{
 		width: 320px;
 	}
 	.footer .info-footer h2{
 		display: inline-block;
 		margin-top: -20px;
 	}
 	.formbox-title-599739{
 		width: 100%;
 	}
 	.header-texto h2{
 		font-size: 19px;
 	}
 	.header-texto p{
 		font-size: 17px;
 	}
 	#btnSubmit{
 		width: 320px;
 	}

 }
</style>
<script type="text/javascript">
function CheckField599739(fldName, frm){ if ( frm[fldName].length ) { for ( var i = 0, l = frm[fldName].length; i < l; i++ ) {  if ( frm[fldName].type =='select-one' ) { if( frm[fldName][i].selected && i==0 && frm[fldName][i].value == '' ) { return false; }  if ( frm[fldName][i].selected ) { return true; } }  else { if ( frm[fldName][i].checked ) { return true; } }; } return false; } else { if ( frm[fldName].type == "checkbox" ) { return ( frm[fldName].checked ); } else if ( frm[fldName].type == "radio" ) { return ( frm[fldName].checked ); } else { frm[fldName].focus(); return (frm[fldName].value.length > 0); }} }
function rmspaces(x) {var leftx = 0;var rightx = x.length -1;while ( x.charAt(leftx) == ' ') { leftx++; }while ( x.charAt(rightx) == ' ') { --rightx; }var q = x.substr(leftx,rightx-leftx + 1);if ( (leftx == x.length) && (rightx == -1) ) { q =''; } return(q); }
function checkfield(data) {if (rmspaces(data) == ""){return false;}else {return true;}}
function isemail(data) {var flag = false;if (  data.indexOf("@",0)  == -1 || data.indexOf("\\",0)  != -1 ||data.indexOf("/",0)  != -1 ||!checkfield(data) ||  data.indexOf(".",0)  == -1  ||  data.indexOf("@")  == 0 ||data.lastIndexOf(".") < data.lastIndexOf("@") ||data.lastIndexOf(".") == (data.length - 1)   ||data.lastIndexOf("@") !=   data.indexOf("@") ||data.indexOf(",",0)  != -1 ||data.indexOf(":",0)  != -1 ||data.indexOf(";",0)  != -1  ) {return flag;} else {var temp = rmspaces(data);if (temp.indexOf(' ',0) != -1) { flag = true; }var d3 = temp.lastIndexOf('.') + 4;var d4 = temp.substring(0,d3);var e2 = temp.length  -  temp.lastIndexOf('.')  - 1;var i1 = temp.indexOf('@');if (  (temp.charAt(i1+1) == '.') || ( e2 < 1 ) ) { flag = true; }return !flag;}}
function _checkSubmit599739(frm){
if ( !isemail(frm["fldEmail"].value) ) { 
   alert("Por favor introduzca el Email");
   return false;
}
 return true; }
 function myFunction() {
    $("#btnSubmit").prop('disabled', ! $("#btnSubmit").prop('disabled') );
    $("#btnSubmit").css({"opacity": "1", "cursor": "pointer"});
}
function getTime() {
	now = new Date();
	y2k = new Date("Nov 31 2015 23:59:59");
	days = (y2k - now) / 1000 / 60 / 60 / 24;
	daysRound = Math.floor(days);
	hours = (y2k - now) / 1000 / 60 / 60 - (24 * daysRound);
	hoursRound = Math.floor(hours);
	minutes = (y2k - now) / 1000 /60 - (24 * 60 * daysRound) - (60 * hoursRound);
	minutesRound = Math.floor(minutes);
	seconds = (y2k - now) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound);
	secondsRound = Math.round(seconds);
	sec = (secondsRound == 1) ? " segundo" : " segundos";
	min = (minutesRound == 1) ? " minuto" : " minutos, ";
	hr = (hoursRound == 1) ? " hora" : " horas, ";
	dy = (daysRound == 1) ? " día" : " d&iacute;as, "
	document.getElementById("counter").innerHTML = "Faltan " + daysRound + dy + hoursRound + hr + minutesRound + min + secondsRound + sec;
	newtime = window.setTimeout("getTime();", 1000);
}
</script>


<div class="principal-container">
	<div class="container" align="center">
		<div class="logo"></div>
		<div class="header-texto">
			<h2>Te invitamos en Diciembre al evento virtual más importante de ofertas inmobiliarias de la Costa.
			Decenas de proyectos de vivienda e inversión, oportunidades de financiación e información de interés sólo a un click de distancia.</h2>
			<p>Regístrate aquí para que no te pierdas ninguna de las promociones y beneficios de la Feria.</p>
		</div>
		<div align="center">
		<body onLoad="getTime()">
		</div>
		<p style="color: #fff;text-align: center;font-family: 'Dosis', sans-serif;font-size: 20px;background-color: #33607B;padding: 5px;border-radius: 5px;border: 1px solid #91EBF1;" id="counter"></p>
		<div class="formbox-editor-599739">
			<form style="display:inline;" action="https://lb.benchmarkemail.com//code/lbform" method=post name="frmLB599739" accept-charset="UTF-8" onsubmit="return _checkSubmit599739(this);" >
				<input type=hidden name=successurl value="http://www.benchmarkemail.com/Code/ThankYouOptin?language=spanish" />
				<input type=hidden name=errorurl value="http://lb.benchmarkemail.com//Code/Error" />
				<input type=hidden name=token value="mFcQnoBFKMRTC%2B929Mt7tOZXUawFafLCnqwDez2JRw01SgsGRzPBIg%3D%3D" />
				<input type=hidden name=doubleoptin value="" /><fieldset><div class="formbox-title-599739"><br></div></fieldset>
				<fieldset class="formbox-field-email-599739">
					<input type=text placeholder="E-mail" class="formbox-field-599739" name="fldEmail" maxlength=100 />
				</fieldset>
				<fieldset><input type="submit" id="btnSubmit" value="Suscribirme"  krydebug="1751" class="formbox-button-599739" disabled /></fieldset>
				<input type="checkbox" name="acepto" value="Bike" onclick="myFunction()" style="float:left;width: 18px;height: 20px;"><p class="terms">Acepto términos, condiciones y políticas de privacidad</p>
			</form>
		</div>
	</div>
</div>
<div class="footer">
	<div class="info-footer">
		<h2>En la Feria <span style="color: #000;">encontrarás</span></h2>
		<div class="logo-footer"></div>
	</div>
</div>
