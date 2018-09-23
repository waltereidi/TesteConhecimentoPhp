<?php

$link= mysqli_connect("127.0.0.1" , "root" , "");
mysqli_select_db($link , "onclickphptest");

if(isset($_GET['oper'])){
	$o = $_GET['oper'];
switch($o){
//############################################################################
//############################################################################
case 0 : 
if(isset($_POST['nome']))$nome = 	$_POST['nome']; else $nome= null;
if(isset($_POST['cpf']))$cpf =  	$_POST['cpf'] ;else $cpf= null;
if(isset($_POST['mail']))$mail = 	$_POST['mail']; else $mail= null;
if(isset($_POST['data_nsc']))$data_nsc = $_POST['data_nsc'] ;else $data_nsc= null;
if(isset($_POST['telefone']))$telefone = $_POST['telefone'] ;else $telefone= null;
if(isset($_POST['senha']))$senha = 	$_POST['senha'] ;else $senha= null;

if($_GET['opt'] == '3'){
mysqli_query($link , 'UPDATE `onclickphptest`.`cliente` SET `cli_nome`="'.$nome.'", `cli_cpf`  ="'.$cpf.'" ,`cli_email`  ="'.$mail.'" , `cli_data_nascimento`  ="'.$data_nsc.'", `cli_telefone` ="'.$telefone.'" ,  `cli_senha`  ="'.$senha.'" WHERE cli_id = '.$_GET['id'].';');

}else{
mysqli_query($link , 'INSERT INTO `onclickphptest`.`cliente`( `cli_nome`, `cli_cpf`,`cli_email`, `cli_data_nascimento`, `cli_telefone`,  `cli_senha`) 
	VALUES ( "'.$nome.'" , "'.$cpf.'" ,"'.$mail.'" ,"'.$data_nsc.'" ,"'.$telefone.'" ,"'.$senha.'"  );');
}

$result = mysqli_query($link , "SELECT MAX(cli_id) AS cli_id FROM cliente ;");
$row = mysqli_fetch_assoc($result); 
echo $row['cli_id'];


break;  
//############################################################################
//############################################################################

case 1 :
$result = mysqli_query($link ,'SELECT cli_id ,cli_nome, cli_cpf,cli_email, cli_data_nascimento, cli_telefone FROM cliente  ORDER BY cli_id DESC LIMIT 1' );
$row = mysqli_fetch_assoc($result);
echo '<tr onclick="expandinfo(id)" data-toggle="modal" data-target="#myModal"  onmouseover="showbtn(id)" onmouseout=" hidebtn(id)" id="'.$row['cli_id'].'" ><td> '.$row['cli_nome'].' </td> <td>'.$row['cli_cpf'].'</td> <td>'.$row['cli_telefone'].'</td> <td>'.$row['cli_email'].'</td> <td> <button id="dbtn'.$row['cli_id'].'" onclick="delrow(id)" type="button" style="display: none;" class="btn btn-danger">X</button> </td></tr>';

break;
//############################################################################
//############################################################################

case 2 : 
if(isset($_GET['id']))$idlastinsert 				 = $_GET['id'];					else $idlastinsert   =null;
if(isset($_GET['opt']))$option 				 	     = $_GET['opt'];				else $option 	     =null;
if(isset($_POST['end_titulo']))$end_titulo 		  	 = $_POST['end_titulo'];	    else $end_titulo     =null;
if(isset($_POST['end_rua']))$end_rua  	 		  	 = $_POST['end_rua'] 	;	    else $end_rua	     =null;
if(isset($_POST['end_numero']))$end_numero 		  	 = $_POST['end_numero'];	    else $end_numero     =null;
if(isset($_POST['end_complemento']))$end_complemento = $_POST['end_complemento'] ;  else $end_complemento=null;
if(isset($_POST['end_bairro']))$end_bairro       	 = $_POST['end_bairro'] ;	    else $end_bairro	 =null;
if(isset($_POST['end_cidade']))$end_cidade 		 	 = $_POST['end_cidade'] ;	    else $end_cidade	 =null;
if(isset($_POST['end_estado']))$end_estado 		 	 = $_POST['end_estado'] ;	    else $end_estado	 =null;
// if(isset($_GET['ttx']))
if($option == 0){
$sql = 'INSERT INTO `cliente_endereco` 
	(`end_id_cliente_fk`, `end_titulo`, `end_rua`, 
	 `end_numero`, `end_complemento`, `end_bairro`, 
	 `end_cidade`, `end_estado`, `end_data_cadastro`, 
	 `end_ordem`) 
	 SELECT 
	 a.cli_id , "'.$_POST['end_titulo'].'" , "'.$_POST['end_rua'].'" , 
	 "'.$_POST['end_numero'].'" , 	"'.$_POST['end_complemento'].'" , "'.$_POST['end_bairro'].'" , 
 	 "'.$_POST['end_cidade'].'" ,"'.$_POST['end_estado'].'" , NOW() ,
 	 IF(end_ordem IS NULL , 0 , end_ordem+1 )
 	 FROM cliente AS a 
	 LEFT JOIN (SELECT MAX(end_ordem) AS end_ordem , end_id_cliente_fk FROM cliente_endereco WHERE end_id_cliente_fk = "'.$idlastinsert.'" ) 
	 AS b ON b.end_id_cliente_fk = "'.$idlastinsert.'" 
	 WHERE a.cli_id = "'.$idlastinsert.'" ';

}else{
$sql = 'UPDATE `cliente_endereco` 
	 SET `end_titulo` = "'.$_POST['end_titulo'].'" , `end_rua` = "'.$_POST['end_rua'].'" , 
	 `end_numero` = "'.$_POST['end_numero'].'", `end_complemento` ="'.$_POST['end_complemento'].'" , `end_bairro` ="'.$_POST['end_bairro'].'" , 
	 `end_cidade` = "'.$_POST['end_cidade'].'", `end_estado` = "'.$_POST['end_estado'].'"
 	  WHERE end_id = "'.$idlastinsert.'"';

}
mysqli_query($link , $sql );

echo '1';
 

break; 
//############################################################################
//############################################################################

case 3 :
if(isset($_GET['mark'])) {$marca=$_GET['mark'] ; }
$result = mysqli_query($link , 'SELECT end_id , end_ordem FROM cliente_endereco WHERE end_id_cliente_fk ='.$_GET['id'].' ORDER BY end_ordem ASC');

echo '<br>Endere&ccedil;os<br><div  id="btnaddn" onclick="newformend()" class="btn btn-warning" style="margin:2px;"> + </div>' ; 

while($row = mysqli_fetch_assoc($result) ){

echo '<div  title="Criar novo Endere&ccedil;o" id="pg'.$row['end_id'].'" onclick="pageselect(id)" class="'.(($marca == $row['end_id']) ? "btn btn-danger" : "btn btn-default").'" style="margin:2px;" >'.($row['end_ordem']+1).'</div>' ; 

}



break ;
//############################################################################
//############################################################################

case 4 : 
$result = mysqli_query($link , "SELECT `end_titulo`, `end_rua`, 
	 `end_numero`, `end_complemento`, `end_bairro`, 
	 `end_cidade`, `end_estado`,  `end_ordem`,
	 `end_id` 
	 FROM cliente_endereco WHERE end_id = ".$_GET['id']); 
$row= mysqli_fetch_assoc($result);
echo 
'<form id="cadEndereco" action="" method="post">
Endere&ccedil;o N° 
<input style="margin-bottom:5px;" name="end_titulo"  	  id="end_titulo" data-ctm="'.$row['end_id'].'" type="text" class="form-control" placeholder="Titulo" value="'.$row['end_titulo'].'" >
<input style="margin-bottom:5px;" name="end_rua"  	  	  id="end_rua" 	  	   type="text"class="form-control" placeholder="Rua" value="'.$row['end_rua'].'" >
<input style="margin-bottom:5px;" name="end_numero" 	  id="end_numero" 	   type="number" class="form-control" placeholder="N°" value="'.$row['end_numero'].'" >
<input style="margin-bottom:5px;" name="end_complemento" id="end_complemento" type="text" class="form-control" placeholder="complemento"  value="'.$row['end_complemento'].'" >
<input style="margin-bottom:5px;" name="end_bairro"	  id="end_bairro"	   type="text" class="form-control" placeholder="Bairro" value="'.$row['end_bairro'].'" >
<input style="margin-bottom:5px;" name="end_cidade"	  id="end_cidade"	   type="text" class="form-control" placeholder="Cidade" value="'.$row['end_cidade'].'" >
<input style="margin-bottom:5px;" name="end_estado"	  id="end_estado"	   type="text" class="form-control" placeholder="Estado" value="'.$row['end_estado'].'" >
<div id="btncontainer"></div>
<br/><br/>
</form>';
break;
//############################################################################
//############################################################################
case 5:
mysqli_query($link , "DELETE a.*,b.* FROM cliente AS a 
LEFT JOIN cliente_endereco AS b ON a.cli_id = b.end_id_cliente_fk 
WHERE cli_id=".$_GET['id'] );
echo '1';
break;

//############################################################################
//############################################################################
case 6 :

$result = mysqli_query($link , "SELECT cli_id, `cli_nome`, `cli_cpf`,`cli_email`, `cli_data_nascimento`, `cli_telefone`,  `cli_senha` FROM cliente WHERE cli_id=".$_GET['id']);
$row    = mysqli_fetch_assoc($result);
echo '<form id="cadUsuario" action="" method="post">
<input style="margin-bottom:5px;" name="nome" id="nome" type="text"  data-ctm="'.$row['cli_id'].'"   value="'.$row['cli_nome'].'" class="form-control" placeholder="Nome">
<input style="margin-bottom:5px;" name="cpf"  id="cpf"  type="number"					      value="'.$row['cli_cpf'].'" class="form-control" placeholder="CPF">
<input style="margin-bottom:5px;" name="mail" id="mail" type="text"  					      value="'.$row['cli_email'].'" class="form-control" placeholder="E-mail">
Data de Nascimento<input style="margin-bottom:5px;" name="data_nsc" id="data_nsc" type="date" value="'.$row['cli_data_nascimento'].'" class="form-control" >
<input style="margin-bottom:5px;" name="telefone" id="telefone" type="text" 				  value="'.$row['cli_telefone'].'" class="form-control" placeholder="Telefone">
<input style="margin-bottom:5px;" name="senha" id="senha" type="password" 					  value="'.$row['cli_senha'].'" class="form-control" placeholder="Senha">
<br/><br/><div id="btncontainer"></div>
</form>';
break ; 
}



}


?>