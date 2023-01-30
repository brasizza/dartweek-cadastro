require('./bootstrap');

var enviado = false;
import Swal from 'sweetalert2';

var hash = process.env.MIX_HASH_CERTIFICDO;

let pieces = [];
for (let i = 0; i < hash.length; i += 4) {
    pieces.push(hash.substring(i, i + 4));
}


    function validateComplete(){

        var stringCompleta = '';
        $('.codigo').each(function(index,element) {

            stringCompleta = stringCompleta+ $(element).val();

            if(stringCompleta == hash){


                console.log("OPA IGUAIS!!!!");
                confirmDialog();

        }
        });
    }


    window.confirmDialog = function()
{


    if(enviado == false){
    var htmlFields = '<span>Digite seu Nome e E-mail para envio do seu certificado de conclusão!</span><div class="row">';
        htmlFields = htmlFields + '<hr><div class="col-lg-5"><input type="password" id="prevent_autofill" autocomplete="off" style="display:none" tabindex="-1" /><span style="font-size: 18px">Nome:</span></div><div class="col-lg-7"><input id="nome_certificado" type="text" class="form-control" placeholder="Seu nome completo" autocomplete="off" autofocus ><hr></div>';

    htmlFields = htmlFields+ '<div class="col-lg-5"><span style="font-size: 18px">E-mail:</span></div><div class="col-lg-7"><input id="email_certificado" type="email" class="form-control" placeholder="E-mail" autocomplete="off"></div>';
    htmlFields = htmlFields + "</div>";
    Swal.fire({
        title: 'Codigo digitado com sucesso!!',
        html: htmlFields,
        didOpen: function (el) {
            $('#nome_certificado').trigger('focus');
            },

        allowOutsideClick: false,
      }).then((result) => {
        if (result.isConfirmed) {

            let nome = $("#nome_certificado").val();
            let email = $("#email_certificado").val();


            $.ajax({
                type: "POST",
                beforeSend: beforeSendFunction,
                // async: false,

                // contentType: "application/json; charset=UTF-8",
                data: {
                    'email': email,
                    'nome' : nome,

                },
                url:'/api/enviar-certificado',
                dataType: 'text', // in ,my case the absence of this was the cause of failure
            })
                // in case of successfully understood ajax response
                .done(function (resultAjax) {

                    Swal.fire('Sucesso', 'Certificado enviado para seu email', 'success');
                    enviado = true;

                    $('.codigo').each(function(index,element) {
                        $(element).val('');
                        if(index == 0){
                            $(element).trigger('focus');
                        }
                    });

                }) .fail(function (erordata) {

                    console.log(erordata);
                     Swal.fire('Erro', 'Falha ao enviar o email, Caso o erro persista, envie uma mensagem!', 'error');
                })

        }
      })
    }else{
        Swal.fire('Certificado', 'Seu certificado já foi emitido', 'success');

    }
}

    window.validateCode = function(code, index) {
        if (code.length == 4) {

            console.log('ASDASD');
            if (pieces[index] == code) {
                $('#icone_codigo_' + index).attr('src', '/images/icones/correto.png');
                if(index < 5){
                    $("#codigo_"+(parseInt(index)+1)).trigger('focus')
                }

            } else {

                $('#icone_codigo_' + index).attr('src', '/images/icones/erro.png');

               // $('#icone_codigo_' + index).removeClass('fa-hourglass').remove('fa-circle-check').removeClass('fa-circle-xmark').removeClass('text-success').removeClass('text-danger').removeClass('text-primary').addClass('fa-circle-xmark').addClass('text-danger');

            }

            validateComplete();


        }else{
            $('#icone_codigo_' + index).attr('src', '/images/icones/sem_digitacao.png');

        }

    }


    function beforeSendFunction() {

        Swal.fire({
            title: 'Processando.....',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }

        })
    }
