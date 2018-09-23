var global_1;
var global_2;
var global_3;
//##############################################################
//##############################################################


 $(document).ready(function() {
         $('#salvar').click(function() {

     
  if(validaCPF(document.getElementById('cpf').value)  && document.getElementById('cpf').value<99999999999 ){
             var dados = $('#cadUsuario').serialize();
  
             $.ajax({
                 type: 'POST',
                 dataType: 'json',
                 url: 'addcliente.php?oper=0&opt=0',
                 async: true,
                 data: dados,
                 success: function(response) {
                // $('#mark').attr('data-ctm', response);
                    global_2 = response;
					 modalay2();
                     addrow();
                     btnsalvarhd();
                 }
             });
  	
             return false;
         }else{alert("CPF INVALIDO!");}

     });
  
    

 });
//##############################################################
//##############################################################
//##############################################################

function validaCPF(cpf)
  {	

    var numeros, digitos, soma, i, resultado, digitos_iguais;
    if(cpf == "")
    	{return true;}
    digitos_iguais = 1;
    if (cpf.length < 11)
          return false;
    for (i = 0; i < cpf.length - 1; i++)
          if (cpf.charAt(i) != cpf.charAt(i + 1))
                {
                digitos_iguais = 0;
                break;
                }
    if (!digitos_iguais)
          {
          numeros = cpf.substring(0,9);
          digitos = cpf.substring(9);
          soma = 0;
          for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(0))
                return false;
          numeros = cpf.substring(0,10);
          soma = 0;
          for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(1))
                return false;
          return true;
          }
    else
        return false;
  }

//##############################################################
//##############################################################
//##############################################################
function addrow(){

    $.ajax({url: "addcliente.php?oper=1", success: function(result){
	$('#tabeladinamica tr:last').after(result);
      

    }});
}
function reloadrow(){

    $.ajax({url: "addcliente.php?oper=1", success: function(result){
	$('#tabeladinamica tr:last').after(result);
      

    }});
}

//##############################################################
//##############################################################
//##############################################################

function showbtn(id) {

 document.getElementById("dbtn"+id).style.display = "block";
}

function hidebtn(id) {
 document.getElementById("dbtn"+id).style.display = "none";
}
//##############################################################
//##############################################################
//##############################################################
function modalay() {
	global_1=0;
	global_3=0;
document.getElementById("salvar2").style.display = "none";
document.getElementById("salvar").style.display = "block";
document.getElementById("corpo_modal").innerHTML = 
'<form id="cadUsuario" action="" method="post">'+
'<input style="margin-bottom:5px;" name="nome" id="nome" type="text" class="form-control" placeholder="Nome">'+
'<input style="margin-bottom:5px;" name="cpf"  id="cpf" type="number"class="form-control" placeholder="CPF">'+
'<input style="margin-bottom:5px;" name="mail" id="mail" type="text" class="form-control" placeholder="E-mail">'+
'Data de Nascimento<input style="margin-bottom:5px;" name="data_nsc" id="data_nsc" type="date" class="form-control" >'+
'<input style="margin-bottom:5px;" name="telefone" id="telefone" type="text" class="form-control" placeholder="Telefone">'+
'<input style="margin-bottom:5px;" name="senha" id="senha" type="password" class="form-control" placeholder="Senha">'+
'<br/><br/>'+
'</form>';
}

function modalay2() {

$( "#corpo_modal" ).html(
'<form id="cadEndereco" action="" method="post">'+
'Endere&ccedil;o N° '+
'<input style="margin-bottom:5px;" name="end_titulo"  	  id="end_titulo" 	   type="text" class="form-control" placeholder="Titulo">'+
'<input style="margin-bottom:5px;" name="end_rua"  	  	  id="end_rua" 	  	   type="text"class="form-control" placeholder="Rua">'+
'<input style="margin-bottom:5px;" name="end_numero" 	  id="end_numero" 	   type="number" class="form-control" placeholder="N°">'+
'<input style="margin-bottom:5px;" name="end_complemento" id="end_complemento" type="text" class="form-control" placeholder="complemento" >'+
'<input style="margin-bottom:5px;" name="end_bairro"	  id="end_bairro"	   type="text" class="form-control" placeholder="Bairro">'+
'<input style="margin-bottom:5px;" name="end_cidade"	  id="end_cidade"	   type="text" class="form-control" placeholder="Cidade">'+
'<input style="margin-bottom:5px;" name="end_estado"	  id="end_estado"	   type="text" class="form-control" placeholder="Estado">'+
'<div id="btncontainer"></div>'+
'<br/><br/>'+
'</form>'
);
}
//##############################################################
//##############################################################
function btnsalvarhd(){

 document.getElementById("salvar").style.display  = "none";
 document.getElementById("salvar2").style.display = "block";
}
//##############################################################



 $(document).ready(function() {
 	
         $('#salvar2').click(function() {
         	var link; 
  			 //var marca =;
  			 // $("#mark").attr('data-ctm');
             var dados = 	$('#cadEndereco').serialize();
             switch(global_1){
             	case 0 : 
             	link = 'addcliente.php?oper=2&opt='+global_1+'&id='+global_2;break;
             	case 1 :
             	link = 'addcliente.php?oper=2&opt='+global_1+'&id='+$("#end_titulo").attr('data-ctm');break;
          		
             	case 3 : 
             	link = 'addcliente.php?oper=0&opt='+global_1+'&id='+$("#nome").attr('data-ctm');dados=$('#cadUsuario').serialize();break;
          		
             }
  
             $.ajax({
                 type: 'POST',
                 dataType: 'json',
                 url: link,
                 async: true,
                 data: dados,
                 success: function(response) {
                 
                    buttonboxcontroller();
                    $("#salvar2").hide();
                    if(global_1 == 3 ){
                    	location.reload();

                    }
                 }
             });
  	
             return false;
        

     });
  
    

 });

 //##############################################################
//##############################################################
//##############################################################
function buttonboxcontroller(){
   $.ajax({url: "addcliente.php?oper=3&id="+global_2+"&mark="+global_3, success: function(result){

	$( "#btncontainer" ).html(result);
 }});

}

//##############################################################
//##############################################################
//##############################################################

function pageselect(id) {
	var nid = id.substring(2);
	global_3=nid;
   $.ajax({url: "addcliente.php?oper=4&id="+nid, success: function(result){
	$( "#corpo_modal" ).html(result);
    buttonboxcontroller();
   $("#salvar2").show();
   $("#salvar2").html('Editar');
     global_1 = 1;
    
          }});

 
}
//##############################################################
//##############################################################
//##############################################################
function newformend(){

$("#salvar2").show();
$("#salvar2").html('Criar Novo Endere&ccedil;o');
global_1=0;
global_3=0;
modalay2();
buttonboxcontroller();
}

//##############################################################
//##############################################################
//##############################################################
function delrow(id) {
	
if( confirm("Deseja Realmente Deletar este cliente e todos seus endere&ccedil;os?") ){
   $.ajax({url: "addcliente.php?oper=5&id="+id.substring(4), success: function(result){
   	location.reload();
    
          }});}

}

function expandinfo(id){
 global_1 = 3;
     global_3=  0;
     global_2= id;
   $.ajax({url: "addcliente.php?oper=6&id="+id, success: function(result){
	$( "#corpo_modal" ).html(result);
    buttonboxcontroller();
   $("#salvar2").show();
   $("#salvar").hide();
   $("#salvar2").html('Editar');
    
    buttonboxcontroller();
          }});

};