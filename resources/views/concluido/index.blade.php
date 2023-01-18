<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dart Week - 2023</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,700;1,400;1,700" display="swap"
        rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet" crossorigin="anonymous">
    <link href="/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="/js/app.js"></script>

    <script src="/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

    </style>
</head>

<body>

    <div class="container-fluid mt-5  ">
        <h3 class="text-center"><strong
                style="font-family: Roboto, sans-serif; color: rgb(255, 255, 255); font-size: 40px;">Dart Week -
                Delivery App</strong></h3>
        <h4 class="text-center"><strong style="font-family: Roboto, sans-serif; color: rgb(255, 255, 255);"> Digite os
                códigos passados nas aulas para receber o seu certificado! </strong></h4>
        <div class="col col-lg-12 ">
            <div class="row justify-content-md-center">

                @foreach ($aulas as $idx => $aula)
                    <div class="col col-lg-{{$idx == 5 ? '4' : '3'}} text-center" style="margin-right:30px;!important">
                        <div class="card mb-3"  @if ($idx == 5 ) style="background-color: #e0d599" @endif>
                            <div class="card-header">
                                {{$aula['titulo']}}
                              </div>
                            <img src="{{ $aula['imagem'] }}" alt="image" class="img-rounded img-responsive">
                            <div class="card-footer text-center">
                                <div class="row">
                                    <div class="col-8"> <input type="text" class="form-control form-control-sm codigo" name="codigo_{{ $idx }}" id="codigo_{{$idx}}"
                                        placeholder=""  onkeyup="validateCode(this.value,'{{$idx}}')" maxlength="4" {{ ($idx == 0 ) ? 'autofocus' : '' }}></div>
                                    <div class="col-4"> <i class="fa-solid fa-xl text-primary fa-hourglass icone_codigo" id="icone_codigo_{{$idx}}" ></i></div>
                                  </div>
                              </div>

                        </div>


                        {{-- <div class="col-lg-3 text-center" style="margin-right:30px;!important">
                        <div class="col-12">
                            <img src="{{ $aula['imagem'] }}" alt="image" class="img-thumbnail">
                        </div>

                        <div class="text-center">
                            <div class="row  mt-4 mb-4 text-center offset-3  ">
                              <div class="col-8 col-lg-8">
                                <input type="text" class="form-control form-control-sm codigo" name="codigo_{{ $idx }}" id="codigo_{{$idx}}"
                                placeholder=""  onkeyup="validateCode(this.value,'{{$idx}}')" maxlength="4" {{ ($idx == 0 ) ? 'autofocus' : '' }}>
                              </div>
                              <div class="col-1 col-lg-1">
                                <i class="fa-solid fa-xl fa-hourglass icone_codigo" id="icone_codigo_{{$idx}}" ></i>
                              </div>

                            </div>
                          </div>

                    </div> --}}
                    @if ($idx == 4 )
                    </div>
                    <div class="row justify-content-md-center">


                    @endif
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</body>

</html>
