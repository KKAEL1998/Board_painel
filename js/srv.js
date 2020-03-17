//$('#case-cards-server')
$(document).on('click', '.glyphicon-plus-sign', function () {
    $(this).removeClass('glyphicon-plus-sign').addClass('glyphicon-minus-sign');
    $(this).parents(".case-panel-heading").next().find(".card-infos").collapse('toggle');
    //$(this).parents(".case-panel-heading").next().find(".card-infos").slideToggle('');

    $(this).parents('.card-srv').find('input').each(function () {
        $(this).removeAttr('disabled');
    });
    $(this).parents('.card-srv').find('.btn-servicos-dis').each(function () {
        $(this).removeClass('btn-servicos-dis').addClass('btn-servicos-upd');
    });
    $(this).parents('.card-srv').find('.case-bt-acao').each(function () {
        $(this).removeClass('case-bt-acao').addClass('case-bt-acao-on');
    });
    $(this).parents('.card-srv').find('.case-btns-servicos-dis').each(function () {
        $(this).removeClass('case-btns-servicos-dis').addClass('case-btns-servicos');
    });
    $(this).parents('.card-srv').find('.btn-add-srvc').each(function () {
        $(this).removeClass('btn-add-srvc-dis');
    });

});
$(document).on('click', '.glyphicon-minus-sign', function () {

    $(this).removeClass('glyphicon-minus-sign').addClass('glyphicon-plus-sign');
    $(this).parents(".case-panel-heading").next().find(".card-infos").collapse('toggle');

    $(this).parents('.card-srv').find('.btn-servicos-upd').each(function () {
        $(this).removeClass('btn-servicos-upd').addClass('btn-servicos-dis');
    });
    $(this).parents('.card-srv').find('.case-bt-acao-on').each(function () {
        $(this).removeClass('case-bt-acao-on').addClass('case-bt-acao');
    });
    $(this).parents('.card-srv').find('.case-btns-servicos').each(function () {
        $(this).removeClass('case-btns-servicos').addClass('case-btns-servicos-dis');
    });
    $(this).parents('.card-srv').find('.btn-add-srvc').each(function () {
        $(this).addClass('btn-add-srvc-dis');
    });

});

$(document).on('click', '.btn-add-srvc', function () {

    let obj = $(this).parents('.case-btns-servicos').next().find('.bt-upd-inf-srv');
    let id = obj.attr('data-id');
    let url = '../mod/srv/' + srv + '/class/';
    uop.ajax({
        url: url,
        dataType: 'text',
        type: 'post',
        data: {
            rq: "getLstSrvr",
            idServer: id,
            op: 'option'
        },
        success: function (rs) {
            let campos = new FormData();
            bootbox.dialog({
                title: 'Insira as informações do serviço:',
                message: '\
                    <label for="list_srvc">Serviço:</label>\
                    <select class="form-control list_srvc" id="list_srvc">'+rs+'</select>\
                    <label for="svc-user">Usuário:</label>\
                    <input type="text" id="svc-user" class="form-control svc-user" name="svc-user">\
                    <label for="svc-psw">Senha:</label>\
                    <input type="password" id="svc-psw" class="form-control svc-psw" name="Svc-psw">\
                ',
                size: 'small',
                onEscape: true,
                backdrop: true,
                buttons: {
                    Guardar: {
                        label: 'Adicionar',
                        className: 'btn-success',
                        callback: function () {
                            let nm_srvc = $('#list_srvc :selected').val();
                            let user_srvc = $('.svc-user').val();
                            let psw_srvc = $('.svc-psw').val();
                            //alert(nm_srvc)
                            //alert(user_srvc)
                            //alert(psw_srvc)
                            campos.append('id',id);
                            campos.append('user_srvc', user_srvc);
                            campos.append('psw_srvc', psw_srvc);
                            campos.append('nm_srvc', nm_srvc);
                            campos.append('rq', 'setSrvc');
                            campos.append('op', 'listar');
                            uop.ajax({
                        url: url,
                        dataType: 'text',
                        type: 'post',
                        contentType: false,
                        processData: false,
                        data: campos,
                        success: function (rs) {
                            $('#alert-set').show().fadeOut(2000);
                            $(this).parents('.case-btns-servicos-save').append(rs);
                            //alert(rs);
                        },
                        error: function (e) {
                            bootbox.alert("<h2>Erro :(</h2><br/><center>Não foi possivel abrir este aplicativo.</center></br>Contate a Equipe Infor caso o erro persista");
                        }
                    });
                        }
                    },
                    Cancelar: {
                        label: 'Cancelar',
                        className: 'btn-danger',
                        callback: function () {
                        }
                    }
                }
            });
        },
        error: function (e) {
            bootbox.alert("<h2>Erro :(</h2><br/><center>Não foi possivel abrir este aplicativo.</center></br>Contate a Equipe Infor caso o erro persista");
        }
    });        
});

$(document).on('click', '.btn-servicos-upd', function () {
    let nm_srvc = $(this).attr("name");
    //console.log(nm_srvc);
    let obj = $(this).parents('.case-btns-servicos').next().find('.bt-upd-inf-srv');
    let user_srvc = $(this).attr("data-user");
    let psw_srvc = $(this).attr("data-psw");
    bootbox.dialog({
        title: 'Altere as informações do serviço:',
        message: '<label for="svc-user">Usuário:</label> <input type="text" id="svc-user" class=" svc-user form-control" name="svc-user" value="' + user_srvc + '"><label for="Svc-psw">Senha:</label> <input type="text" id="svc-psw" class=" svc-psw form-control" name="svc-psw" value="' + psw_srvc + '"><br>',
        size: 'small',
        onEscape: true,
        backdrop: true,
        buttons: {

            Enviar: {
                label: 'Salvar',
                className: 'btn btn-info',
                callback: function () {
                    let campos1 = new FormData();
                    let user_srvc = $('.svc-user').val();
                    let psw_srvc = $('.svc-psw').val();
                    campos1.append('user_srvc', user_srvc);
                    campos1.append('psw_srvc', psw_srvc);
                    campos1.append('nm_srvc', nm_srvc);
                    let id = obj.attr('data-id');
                    campos1.append('id', id);
                    campos1.append('rq', 'updSrvc');
                    let url = '../mod/srv/' + srv + '/class/';
                    uop.ajax({
                        url: url,
                        dataType: 'text',
                        type: 'post',
                        contentType: false,
                        processData: false,
                        data: campos1,
                        success: function (rs) {
                            $('#alert-upd').show().fadeOut(2000);
                        },
                        error: function (e) {
                            bootbox.alert("<h2>Erro :(</h2><br/><center>Não foi possivel abrir este aplicativo.</center></br>Contate a Equipe Infor caso o erro persista");
                        }
                    });
                }
            }
        }
    });
});

let campos = new FormData();
$(document).on('click', '.btn-servicos', function () {
    let nm_srvc = $(this).attr("id");
    console.log(nm_srvc);
    let objeto = $(this);
    let user_srvc = '';
    let psw_srvc = '';
    let ativo = $(this).attr("data-ativo");
    if (ativo == "true") {
        $(this).attr('data-ativo', false);
    } else {
        bootbox.dialog({
            title: 'Insira as informações do serviço:',
            message: '<label for="svc-user">Usuário:</label> <input type="text" id="svc-user" class="form-control svc-user" name="svc-user">' + '<label for="svc-psw">Senha:</label> <input type="password" id="svc-psw" class="form-control svc-psw" name="Svc-psw"><br>',
            size: 'small',
            onEscape: true,
            backdrop: true,
            buttons: {
                Guardar: {
                    label: 'Guardar',
                    className: 'btn-success',
                    callback: function () {
                        objeto.attr('data-ativo', true);
                        user_srvc = $('.svc-user').val();
                        psw_srvc = $('.svc-psw').val();
                        campos.append('user_srvc', user_srvc);
                        campos.append('psw_srvc', psw_srvc);
                        campos.append('nm_srvc', nm_srvc);
                    }
                },
                Cancelar: {
                    label: 'Cancelar',
                    className: 'btn-danger',
                    callback: function () {
                    }
                }
            }
        });
    }
});
$(document).on('click', '.bt-save-info-srv', function () {
    //var campos = new FormData();
    $(this).parents(".card-srv").find('[data-cp=1]').each(function () {
        let cp = $(this).attr("name");
        let vl = $(this).val();
        campos.append(cp, vl);
    });
    campos.append('rq', 'setSrvr');
    campos.append('op', 'listar');
    let url = '../mod/srv/' + srv + '/class/';
    uop.ajax({
        url: url,
        dataType: 'text',
        type: 'post',
        contentType: false,
        processData: false,
        data: campos,
        success: function(rs) {
            $('#alert-set').show().fadeOut(2000);
            $('#lst-card-server').html(rs);
        },
        error: function (e) {
            bootbox.alert("<h2>Erro :(</h2><br/><center>Não foi possivel abrir este aplicativo.</center></br>Contate a Equipe Infor caso o erro persista:");
        }
    });

    //campos.delete('chave');
});

$(document).on('click', '.bt-upd-inf-srv', function () {
    var campos = new FormData();
    obj = $(this);
    $(this).parents(".card-srv").find('[data-cp=1]').each(function () {
        let cp = $(this).attr("name");
        let vl = $(this).val();
        campos.append(cp, vl);
    });
    campos.append('rq', 'updSrvr');
    let id = $(this).attr('data-id');
    campos.append('id', id);
    let url = '../mod/srv/' + srv + '/class/';

    uop.ajax({
        url: url,
        dataType: 'text',
        type: 'post',
        contentType: false,
        processData: false,
        data: campos,
        success: function (rs) {
            $('#alert-upd').show().fadeOut(2000);
        },
        error: function (e) {
            bootbox.alert("<h2>Erro :(</h2><br/><center>Não foi possivel abrir este aplicativo.</center></br>Contate a Equipe Infor caso o erro persista");
        }
    });
});
$(document).on('click', '#alert-upd-close', function () {
    $('#alert-upd').hide();
});