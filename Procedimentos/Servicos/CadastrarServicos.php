<?php 
session_start();

require_once "../../Classes/Conexao.php";
require_once "../../Classes/Servicos.php";

$idUsuario = $_SESSION['IDUser'];
$idCliente = $_POST['clienteSelect'];
$status = $_POST['StatusSelect'];


$obj = new servicos();

$dados = array(
$idCliente,
$idUsuario,
$status,
$_POST['equipamento'] = strtoupper($_POST['equipamento']),	
$_POST['observacao'] = strtoupper($_POST['observacao']),
$_POST['serialNumber'] = strtoupper($_POST['serialNumber']),
$_POST['ordem'] = strtoupper($_POST['ordem'])
);

echo $obj -> cadastrarServicos($dados);
?>