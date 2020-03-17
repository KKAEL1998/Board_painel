<div class="content-header">
    <ol class="breadcrumb">
        <li><a id="3" class="hme" data-menu="1" href="#"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Servidores</li>
    </ol>
    <h3>Servidores</h3>
</div>

<div class="content body">
    <div id="alert-upd" class="alert alert-info alert-success" role="alert">
        <button id="alert-upd-close" type="button" class="close"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso! </strong>Alteração realizada com sucesso.
    </div>
    <div id="alert-set" class="alert alert-info alert-success" role="alert">
        <button id="alert-upd-close" type="button" class="close"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso! </strong>Informações inseridas com sucesso.
    </div>

    <div class="row">
        <div id="case-cards-server" class="row">
            <div class="col-lg-2 card-srv">
                <div class="panel panel-primary">
                    <div class="case-panel-heading panel-heading ">
                        <div class="panel-title">Novo Servidor</div>
                    </div>
                    <div class="panel-body border border-dark rounded">
                        <div  class="card-infos">
                            <label for="ip-servidor">IP:</label>
                            <input id="ip-servidor" data-cp="1" name="ip" type="text" class="form-control form-control-sm ip-servidor">
                            <label for="nm-servidor">Servidor:</label>
                            <input id="nm-servidor" data-cp="1" name="srv" type="text" class="form-control form-control-sm nm-servidor">
                            <label for="nm-dns">DNS:</label>
                            <input id="nm-dns" data-cp="1" name="dns" type="text" class="form-control form-control-sm nm-dns">
                            <label for="nm-usuario">Usuario:</label>
                            <input id="nm-usuario" data-cp="1" name="usr" type="text" class="form-control form-control-sm nm-usuario">
                            <label for="tx-senha">Senha:</label>
                            <input id="tx-senha" data-cp="1" name="psw" type="password" class="form-control form-control-sm tx-senha">
                        </div>
                        <h4>Serviços:</h4>
                        <div class="case-btns-servicos-save">
                            <div class="case-btns-servicos">
                                <div class="btn-servicos btn-primary" id="1" data-ativo="false" title="PostgreSQL" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Serviço: PostgreSQL <br> Usuário:**** <br> Senha:****">
                                    <i class="fas fa-database"></i>
                                </div>
                                <div class="btn-servicos btn-warning" id="2" data-ativo="false"  title="MySQL" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Serviço: Mysql <br> Usuário:**** <br> Senha:****">
                                    <i class="fas fa-database"></i>
                                </div>
                                <div  class="btn-servicos btn-purple" id="3" data-ativo="false"  title="PHP" data-placement="bottom" data-trigger="hover" data-toggle="popover" data-content="Serviço: PhP <br> Usuário:**** <br> Senha:****">
                                    <i class="fab fa-php"></i>
                                </div>
                                <div class="btn-servicos btn-primary" id="4" data-ativo="false" title="Java" data-placement="bottom" data-trigger="hover" data-toggle="popover" data-content="Serviço: Java <br> Usuário:**** <br> Senha:****">
                                    <i class="fab fa-java"></i>
                                </div>
                            </div>
                            <div id="case-bt-acao">
                                <button  type="button" class="btn btn-success bt-save-info-srv">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="lst-card-server" class="col-lg-10">
                <div class="row">
                    <?php
                    include '../../../mod/srv/'.$_SESSION['srv'].'/class/index.php';
                    $a = new Modulo();
                    $a->getLstServer(false);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.btn-servicos-dis[data-toggle="popover"]').popover({html: true});
        //mascara aqui
        $('#ip-servidor').mask('099.099.099.099')
    });
</script>