<html>
<head>
<link rel="stylesheet" type="text/css" href="css\bootstrap.css">
<link rel="stylesheet" type="text/css" href="css\phptest.css">
<link rel="stylesheet" type="text/css" href="css\bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css\bootstrap-grid.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css\bootstrap-grid.min.css">
<link rel="stylesheet" type="text/css" href="css\bootstrap-reboot.css">
<link rel="stylesheet" type="text/css" href="css\bootstrap-reboot.min.css">
<script type="text/javascript" src="js/phptest.js"></script>

</head><body>


<div class="mainlay" >
<h1 class="mainlay">Lista de Clientes</h1>
</div>

<?php
$link= mysqli_connect("127.0.0.1" , "root" , "");
mysqli_query( $link , "CREATE DATABASE IF NOT EXISTS Onclickphptest;");
mysqli_select_db($link , "onclickphptest");
mysqli_query( $link , "CREATE TABLE IF NOT EXISTS `cliente` (
	`cli_id` INT(11) NOT NULL AUTO_INCREMENT ,
	`cli_nome` VARCHAR(60) NOT NULL,
	`cli_cpf` VARCHAR(14) NOT NULL,
	`cli_data_nascimento` DATE NOT NULL,
	`cli_telefone` VARCHAR(15) NULL DEFAULT NULL,
	`cli_email` VARCHAR(100) NULL DEFAULT NULL,
	`cli_senha` VARCHAR(256) NOT NULL,
	`cli_data_cadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`cli_id`),
	INDEX `cli_nome` (`cli_nome`),
	INDEX `cli_cpf` (`cli_cpf`),
	INDEX `cli_data_cadastro` (`cli_data_cadastro`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;");
mysqli_query( $link ,"CREATE TABLE IF NOT EXISTS `cliente_endereco` (
	`end_id` INT NOT NULL AUTO_INCREMENT ,
	`end_id_cliente_fk` INT NOT NULL,
	`end_titulo` VARCHAR(30) NULL,
	`end_rua` VARCHAR(60) NULL,
	`end_numero` VARCHAR(5) NULL,
	`end_complemento` VARCHAR(30) NULL,
	`end_bairro` VARCHAR(60) NULL,
	`end_cidade` VARCHAR(60) NULL,
	`end_estado` CHAR(2) NULL,
	`end_data_cadastro` DATETIME NULL,
	`end_ordem` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`end_id`),
	INDEX `end_id_cliente_fk` (`end_id_cliente_fk`),
	INDEX `end_data_cadastro` (`end_data_cadastro`),
	INDEX `end_cidade` (`end_cidade`, `end_estado`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;");

$table_res= mysqli_query($link , "SELECT * FROM cliente 	  AS a 
							  LEFT JOIN cliente_endereco AS b ON a.cli_id = b.end_id_cliente_fk GROUP BY cli_id;");

?>
<input type="hidden" id="mark" data-ctm="">



<div class="tblay">
<table class="table" id="tabeladinamica">
	<tr><button type="button" style="margin-bottom:10px" onclick="modalay()" class="btn btn-success btn" data-toggle="modal" data-target="#myModal">&nbsp+&nbsp </button> </tr>
 <tr> <th> Nome </th> <th>cpf</th> <th>telefone</th> <th>email</th> <th>&nbsp</th> </tr>

<?php
while( $row=mysqli_fetch_assoc($table_res) ) {

echo '<tr onclick="expandinfo(id)" data-toggle="modal" data-target="#myModal" onmouseover="showbtn(id)" onmouseout=" hidebtn(id)" id="'.$row['cli_id'].'" ><td> '.$row['cli_nome'].' </td> <td>'.$row['cli_cpf'].'</td> <td>'.$row['cli_telefone'].'</td> <td>'.$row['cli_email'].'</td> <td> <button id="dbtn'.$row['cli_id'].'" onclick="delrow(id)" type="button" style="display: none;" class="btn btn-danger">X</button> </td></tr>';
};
?>

</table>
</div>



<div class="container">
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cadastrar novo Cliente</h4>
        </div>
        <div id="corpo_modal" class="modal-body">
      
        	


        </div>
        <div class="modal-footer">
         <button type="button" value="Salvar" id="salvar2" class="btn btn-primary">Criar Novo</button> 
         	
         <button type="button"  value="Salvar" id="salvar"  class="btn btn-primary">Cadastrar</button> 
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>


</body>
</html>


