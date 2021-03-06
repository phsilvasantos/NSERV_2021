
<?php
session_start();
if (isset($_SESSION['User'])) {
?>

<!DOCTYPE html>
<html>
	<body>
		<div class="container">
			<!-- <div> -->
				<!-- USUÁRIO LOGADO -->
				<!-- <div class="text-left">
					<span>USUÁRIO LOGADO: <div id="usuarioLogado"></div></span>
				</div>
			</dv> -->
			<div>
				<!-- STATUS DO CAIXA: -->
				<div class="text-left col-md-12 col-sm-12 col-xs-12 textCabecalho">
					<div id="statusCaixa"></div>
				</div>
			</dv>
			<!-- FALE CONOSCO -->
			<div class="cabecalho bgGray">
				<div class="text-center textCabecalho opacidade">
					<h3><strong>FALE CONOSCO</strong></h3>
				</div>
			</div>
			<!-- TELEFONES -->
			<div class="contatos">
				<article class="conteudo bgGradientFaleConosco">
					<div class="text-center">
						<section class="conteudoContatos">
							<i class="fas fa-phone fa-4x textContatos"></i>
						</section>
					</div>
					<div class="text-center">
						<section class="conteudoContatos">
							<div class="text-center">
								<p class="h5 textContatos">(31) 3390-1115</p>
								<p class="h5 textContatos">(31) 3043-4397</p>
							</div>
						</section>
					</div>
				</article>
			</div>
			<!-- CELULARES -->
			<div class="contatos">
				<article class="conteudo bgGradientFaleConosco">
					<div class="text-center">
						<section class="conteudoContatos">
							<i class="fab fa-whatsapp fa-4x textContatos"></i>
						</section>
					</div>
					<div class="text-center">
						<section class="conteudoContatos">
							<div class="text-center">
								<p class="h5 textContatos">(31) 9 9392-0260</p>
								<p class="h5 textContatos">(31) 9 9165-4448</p>
								<p class="h5 textContatos">(31) 9 9246-6484</p>
							</div>
						</section>
					</div>
				</article>
			</div>
			<!-- ENDEREÇO -->
			<div class="contatos">
				<article class="conteudo bgGradientFaleConosco">
					<div class="text-center">
						<section class="conteudoContatos">
							<i class="fas fa-home fa-4x textContatos"></i>
						</section>
					</div>
					<div class="text-center">
						<section class="conteudoContatos">
							<div class="text-center">
								<p class="h5 textContatos">RUA CEL. JOÃO CAMARGOS - 255</p>
								<p class="h5 textContatos">LOJA 01 - CONTAGEM/MG</p>
							</div>
						</section>
					</div>
				</article>
			</div>
			<!-- E-MAIL -->
			<div class="contatos">
				<article class="conteudo bgGradientFaleConosco">
					<div class="text-center">
						<section class="conteudoContatos">
							<i class="fas fa-envelope fa-4x textContatos"></i>
						</section>
					</div>
					<div class="text-center">
						<section class="conteudoContatos">
							<div class="text-center">
								<p class="h5 textContatos">NSERV@HOTMAIL.COM</p>
							</div>
						</section>
					</div>
				</article>
			</div>
			
			<!-- SERVIÇOS DO MES -->
			<div>
				<div class="servicosMes bgGray">
					<div class="text-center textCabecalho opacidade">
						<h3><strong>SERVIÇOS DO MÊS</strong></h3>
					</div>
				</div>
				<!-- TABELA SERVICOS DO MES -->
				<div class="row">
					<div class="col-sm-12" align="center">
						<div id="tabelaServicosMes"></div>
					</div>
				</div>
			</div>

			<!-- VENDAS DO MES -->
			<div>
				<div class="vendasMes bgGray">
					<div class="text-center textCabecalho opacidade">
						<h3><strong>VENDAS DO MÊS</strong></h3>
					</div>
				</div>
				<!-- TABELA VENDAS DO MES -->
				<div class="row">
					<div class="col-sm-12 tabelas" align="center">
						<div id="tabelaVendasMes"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script type="text/javascript">
	$(document).ready(function() {
		$('#tabelaServicosMes').load('./Views/Principal/tabelaServicosMes.php');
		$('#tabelaVendasMes').load('./Views/Principal/tabelaVendasMes.php');
		moment.locale('pt-br');
        var data = moment().format('DD/MM/YYYY');
        setStatusCaixa(data);
	});

		function editarServicos(idServico) {
			$('#conteudo').load('./Views/Servicos/EditarServicos.php');
			$.ajax({
				type: "POST",
				data: "idServico=" + idServico,
				url: "./Procedimentos/Servicos/ObterDadosServicos.php",
				success: function(r) {
					dado = jQuery.parseJSON(r);
					$('#idServico').val(dado['id_servico']);
					$('#selectStatusU').val(dado['status']);
					$('#informacaoU').val(dado['observacao']);
					$('#ordemServicoU').val(dado['ordem_servico']);
					$('#servicoU').val(dado['servico_realizado']);
					// VERIFICA TÉCNICO
					var identificadorTecnico = dado['id_tecnico'];
					if ((identificadorTecnico === "0") || (identificadorTecnico === "") || (identificadorTecnico === null)) {
						$("#tecnicoU").val("");
					} else {
						$('#tecnicoU').val(identificadorTecnico);
					}
					$('#garantiaU').val(dado['garantia']);
					$('#precoU').val(dado['valor_total']);
					$('#valorTerceiroU').val(dado['valor_terceiro']);
					$('#dataSaidaU').val(dado['data_saida']);
					$('#diagnosticoU').val(dado['diagnostico']);
					// VERIFICAR NF-E
					var $radios = $('input:radio[name = nfeEmitidaU]');
					if (dado['nf_emitida'] === "NAO") {
						$radios.filter('[value = NAO]').prop('checked', true);
						console.log("NOTA FISCAL NÃO EMITIDA.");
					} else if (dado['nf_emitida'] === "SIM") {
						$radios.filter('[value = SIM]').prop('checked', true);
						console.log("NOTA FISCAL JÁ EMITIDA.");
					} else {
						$radios.filter('[value = NAO]').prop('checked', true);
						console.log("NÃO FOI POSSÍVEL IDENTIFICAR EMISSÃO DE NOTA.");
					}
				}
			});
		}
		
		function visualizarServicos(idServico) {
			$('#conteudo').load('./Views/Servicos/VisualizarServicos.php');
			$.ajax({
				type: "POST",
				data: "idServico=" + idServico,
				url: "./Procedimentos/Servicos/ObterDadosServicos.php",
				success: function(r) {
					dado = jQuery.parseJSON(r);
					// DADOS CLIENTE
					$.ajax({
						type: "POST",
						data: "idCliente=" + dado.id_cliente,
						url: './Procedimentos/Utilitarios/ObterDadosResumidoCliente.php',
					}).then(function(data) {
						var result = JSON.parse(data);
						var nomeCliente = result[0];
						var telefoneCliente = result[1];
						var celularCliente = result[2];
						$('#clienteView').val(nomeCliente);
						$('#telefoneClienteView').val(telefoneCliente);
						$('#celularClienteView').val(celularCliente);
					});
					$('#idServicoView').val(dado['id_servico']);
					$('#equipamentoView').val(dado['equipamento']);
					$('#ordemServicoView').val(dado['ordem_servico']);
					$('#serialNumberView').val(dado['serial_number']);
					$('#selectStatusView').val(dado['status']);
					// NOME DO TECNICO
					$.ajax({
						type: "POST",
						data: "idTecnico=" + dado.id_tecnico,
						url: './Procedimentos/Utilitarios/ObterNomeTecnico.php',
					}).then(function(data) {
						var nomeTecnico = JSON.parse(data);
						$('#tecnicoView').val(nomeTecnico);
					});
					$('#informacaoView').val(dado['observacao']);
					$('#diagnosticoView').val(dado['diagnostico']);
					$('#servicoView').val(dado['servico_realizado']);
					$('#garantiaView').val(dado['garantia']);
					$('#precoView').val(dado['valor_total']);
					$('#valorTerceiroView').val(dado['valor_terceiro']);
					$('#dataSaidaView').val(dado['data_saida']);
					// VERIFICAR NF-E
					var $radios = $('input:radio[name = nfeEmitidaView]');
					if (dado['nf_emitida'] === "NAO") {
						$radios.filter('[value = NAO]').prop('checked', true);
						console.log("NOTA FISCAL NÃO EMITIDA.");
					} else if (dado['nf_emitida'] === "SIM") {
						$radios.filter('[value = SIM]').prop('checked', true);
						console.log("NOTA FISCAL JÁ EMITIDA.");
					} else {
						$radios.filter('[value = NAO]').prop('checked', true);
						console.log("NÃO FOI POSSÍVEL IDENTIFICAR EMISSÃO DE NOTA.");
					}
				}
			});
		}

	function verificarUsuario() {
		$.ajax({
		type: "POST",
        url: "./Procedimentos/Verificacoes/VerificarUsuarioLogado.php",
        success: function(r) {
			retorno = $.parseJSON(r);
            $('#usuarioLogado').val(retorno);
        }
		});
	}

	function setStatusCaixa(data) {
        $.ajax({
            type: "POST",
			data: "data=" + data,
            url: "./Procedimentos/Financeiro/VerificarStatusCaixa.php",
            success: function(r) {
                retorno = $.parseJSON(r);
				if(retorno == null){
					$("#statusCaixa").text("STATUS DO CAIXA: ");
				}else{
					$("#statusCaixa").text("STATUS DO CAIXA: " + retorno);
				}
            }
		});
    }
</script>
<?php
} else {
	header("location: ./index.php");
}
?>