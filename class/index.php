<?php

Class Modulo {

    public function getLstServer($opt) {
        $boardDB = new Database("board");
        $sql = "Select id_server,ip,dns,user,psw,nm_server From board.server;";
        $consulta = $boardDB->DbGetAll($sql);

        if($opt){
            return json_encode($consulta);
        } else {
            if (sizeof($consulta) > 0) {
                for ($c = 0; $c < count($consulta); $c++) {
                    ?>
                    <div class="col-lg-2 card-srv">
                        <div class="panel panel-primary">
                            <div class="case-panel-heading panel-heading ">
                                <div class="panel-title ip-servidor "><?php echo $consulta[$c]['ip']; ?></div>
                                <div id="btn-expand-card" class="glyphicon glyphicon-plus-sign" data-toggle="collapse"></div>
                            </div>
                            <div class="panel-body border border-dark rounded ">
                                <div  class="card-infos collapse">
                                    <label for="nm-servidor">Nome Servidor:</label>
                                    <input id="nm-servidor" class="form-control form-control-sm" name="srv" data-cp="1" value="<?php echo $consulta[$c]['nm_server']; ?>" disabled />
                                    <label for="nm-dns">DNS:</label>
                                    <input id="nm-dns" class="form-control form-control-sm" data-cp="1" name="dns" value="<?php echo $consulta[$c]['dns']; ?>" disabled />
                                    <label for="nm-usuario">Usuario:</label>
                                    <input id="nm-usuario" class="form-control form-control-sm" data-cp="1" name="usr" value="<?php echo $consulta[$c]['user']; ?>" disabled />
                                    <label for="tx-senha">Senha:</label>
                                    <input id="tx-senha" class="form-control form-control-sm" data-cp="1"  name="psw" value="<?php echo $consulta[$c]['psw']; ?>" disabled />
                                </div>
                                <h4>Serviços:</h4>
                                <div class="case-btns-servicos-save">
                                    <div class="case-btns-servicos-dis">
                                        <?php
                                        $a = new Modulo();
                                        echo $a->getLstSrvr($consulta[$c]['id_server'], 'botao');
                                        ?>
                                        <div class="btn-add-srvc btn-add-srvc-dis" title="Adicionar serviço">
                                            <i class="fa fa-plus-circle text-green text-green-hover"></i>
                                        </div>
                                    </div>
                                    <div id="case-bt-acao" class = "case-bt-acao">
                                        <button type="button" class="btn btn-success bt-upd-inf-srv" data-id="<?php echo $consulta[$c]['id_server']; ?>">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
    }

    public function getLstSrvr($id, $opt) {
        $boardDB = new Database("board");
        $sql2 = "
            select
                a.nm_srvc,
                a.id_srvc
                From board.srvc a
                Where a.id_srvc not in (select id_srvc From board.server_srvc Where id_server = $id);
        ";
        $sql = "
            select
                a.id_srvc,
                b.id_server,
                b.user,
                b.psw,
                b.status,
                a.nm_srvc,
                a.icon,
                a.dir_pop,
                a.color
                From srvc a
                left Join server_srvc b on a.id_srvc = b.id_srvc
        ";
        if($opt == 'option'){
            //$rs = $boardDB->DbGetAll($sql."Where a.id_srvc not in (select id_srvc From board.server_srvc Where id_server = $id);");
            $rs = $boardDB->DbGetAll($sql2);
            if (sizeof($rs) > 0) {
                ?><option value="0">Selecione</option><?php
                for ($i = 0; $i < count($rs); $i++) {
                    ?><option value="<?php echo $rs[$i]['id_srvc']; ?>"><?php echo $rs[$i]['nm_srvc']; ?></option><?php
                }
            } else {
                ?><option value="0">Sem Serviços</option><?php
            } 
        }
        if($opt == 'listar'){
            $rs = $boardDB->DbGetAll($sql." Where b.id_server = $id;");
            if (sizeof($rs) > 0) {
                for ($i = 0; $i < count($rs); $i++) {
                    ?>
                    <div class="btn-servicos-dis btn-<?php echo $rs[$i]['color']; ?>" name="<?php echo $rs[$i]['id_srvc']; ?>" data-name="<?php echo $rs[$i]['nm_srvc']; ?>" data-user="<?php echo $rs[$i]['user']; ?>" data-psw="<?php echo $rs[$i]['psw']; ?>" data-ativo="<?php echo $rs[$i]['status']; ?>" data-placement="<?php echo $rs[$i]['dir_pop']; ?>" data-trigger="hover" data-toggle="popover" data-content="Serviço: <?php echo $rs[$i]['nm_srvc']; ?> <br> Usuário: <?php echo $rs[$i]['user']; ?> <br> Senha:<?php echo $rs[$i]['psw']; ?>">
                        <i class="<?php echo $rs[$i]['icon']; ?>"></i>
                    </div>
                    <?php
                }
            }
        }
        else {
            $rs = $boardDB->DbGetAll($sql." Where b.id_server = $id;");
            if (sizeof($rs) > 0) {
                for ($i = 0; $i < count($rs); $i++) {
                    ?>
                    <div class="btn-servicos-dis btn-<?php echo $rs[$i]['color']; ?>" name="<?php echo $rs[$i]['id_srvc']; ?>" data-name="<?php echo $rs[$i]['nm_srvc']; ?>" data-user="<?php echo $rs[$i]['user']; ?>" data-psw="<?php echo $rs[$i]['psw']; ?>" data-ativo="<?php echo $rs[$i]['status']; ?>" data-placement="<?php echo $rs[$i]['dir_pop']; ?>" data-trigger="hover" data-toggle="popover" data-content="Serviço: <?php echo $rs[$i]['nm_srvc']; ?> <br> Usuário: <?php echo $rs[$i]['user']; ?> <br> Senha:<?php echo $rs[$i]['psw']; ?>">
                        <i class="<?php echo $rs[$i]['icon']; ?>"></i>
                    </div>
                    <?php
                }
            }
        }

       
    }

    
    public function updSrvr() {
        $boardDB = new Database("board");
        //pegar as variaveis com valores no parametro		
        $id = $_POST["id"];
        $srv = $_POST["srv"];
        $dns = $_POST["dns"];
        $usr = $_POST["usr"];
        $psw = $_POST["psw"];
        $sql = "Update board.server Set dns='" . $dns . "', user='" . $usr . "', psw='" . $psw . "', nm_server='" . $srv . "' where id_server = " . $id . ";";
        $boardDB->DbQuery($sql);
    }
    
    public function updSrvc() {
        // Update errado 
        $id = $_POST["id"];
        $boardDB = new Database("board");
        $user_srvc = $_POST["user_srvc"];
        $psw_srvc = $_POST["psw_srvc"];
        $id_srvc = $_POST["nm_srvc"];
        $sql = "update board.server_srvc Set user='". $user_srvc."', psw='".$psw_srvc."' where id_server = ".$id." and id_srvc=".$id_srvc.";";
        $boardDB->DbQuery($sql);
    }
    
    public function setSrvc($opt) {
        //add serviço num server já existente!
        $boardDB = new Database("board");
        //pegar as variaveis com valores no parametro	
        $user_srvc = $_POST["user_srvc"];
        $id = $_POST["id"];
        $psw_srvc = $_POST["psw_srvc"];
        $nm_srvc = $_POST["nm_srvc"];
        $sql = "Insert into board.server_srvc (id_srvc,id_server,user,psw,status) values ('$nm_srvc','$id','$user_srvc','$psw_srvc','true');";
        $boardDB->DbQuery($sql);
        if($opt == 'listar' ){
            $a = new Modulo();
            echo $a->getLstSrvr($id,$opt);
            //echo $a->getLstSrvr($consulta[$c]['id_server'], 'botao');
        } else {
            if($opt == 'listar' && $rs){
                echo 'true';
            } else {
                echo 'false';
                //echo $opt;
            }
        }


    }

    public function setSrvr($opt) {
        $boardDB = new Database("board");
        //pegar as variaveis com valores no parametro	
        $user_srvc = $_POST["user_srvc"];
        $psw_srvc = $_POST["psw_srvc"];
        $id_srvc = $_POST["nm_srvc"];
        $ip = $_POST["ip"];
        $srv = $_POST["srv"];
        $dns = $_POST["dns"];
        $usr = $_POST["usr"];
        $psw = $_POST["psw"];
        $sql = "Insert into board.server (ip,dns,user,psw,nm_server) values ('$ip','$dns','$usr','$psw','$srv');";
        $boardDB->DbQuery($sql);
        //$idsrv = $boardDB->connection->insert_id;
        $idsrv = mysqli_insert_id($boardDB->connection);
        $sql1 = "insert into board.server_srvc(id_server,user,psw,id_srvc,status) values ('$idsrv','$user_srvc','$psw_srvc','$id_srvc','true');";
        $rs = $boardDB->DbQuery($sql1);

        if($opt == 'listar' && $rs){
            $a = new Modulo();
            echo $a->getLstServer(false);
        } else {
            if($rs){
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    public function testeSenha() {

        include '../../../../docs/class/system/functions.2.0.php';
        $chave = "q6w43a2sc1d6e98r6d5f6dasdfa313d525a35dsf"; //Chave a ser utilizada na criptografia/descriptografia
        $str = "Azul";
        $c = new Funcoes();
        $crypt = $c->criptografia($str, $chave, true);

        echo $upt = "Update server Set psw = '$crypt' Where id_server > 1;";
        $boardDB = new Database("board");
        $boardDB->DbQuery($upt);
    }

}

if (isset($_POST["rq"])) {
    session_start();
    include_once "../../../../docs/class/conexao-db/class.conexao.mysql.php";
    include_once "../../../../docs/class/conexao-db/class.database.mysql.php";

    $loadClass = new Modulo();
    $request = $_POST["rq"];

    switch ($request) {
        case "getlst":
            echo $loadClass->getLstServer(false);
            break;
        case "setSenha":
            echo $loadClass->testeSenha();
            break;
        case "setSrvr":
            $op = $_POST["op"];
            echo $loadClass->setSrvr($op);
            break;
        case "updSrvr":
            echo $loadClass->updSrvr();
            break;
        case "updSrvc":
            echo $loadClass->updSrvc();
            break;
        case "getLstSrvr":
            $id = $_POST["idServer"];
            $opt = $_POST["op"];
            echo $loadClass->getLstSrvr($id, $opt);
            break;
        case "setSrvc":
            $opt = $_POST["op"];
            echo $loadClass->setSrvc($opt);
            break;
    }
}
?>