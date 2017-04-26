<!DOCTYPE html>
<?php
session_start();
$id_empresa = $_SESSION['id_empresa'];
?>
<html>
    <head> 
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>jQuery UI Draggable - Default functionality</title>
        <link rel="stylesheet" type="text/css" href="style/principal.css" media="screen" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="style/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style/sweetalert.css">
        <!--Classes -->

        <script src="Classes/Producto/producto.js"></script>   
        <script src="Classes/Fabrica/VMproductoFactory.js"></script>   
        <script src="Classes/Fabrica/productoFactory.js"></script>  
    </head>
    <script>
        var indiceDiv = 0;
        var id_empresa = <?php echo $id_empresa; ?>;
        var i = 1;
        var productoFinal = new Array();
        var VMFactory = new Array();
        console.log("comence a  crear la aplicacion");
        var data = 'id_empresa=' + id_empresa;
        $.ajax({
            url: 'Ajax/elementos.php',
            type: 'post',
            data: data,
            beforeSend: function () {
                console.log('obteniendo parametros....')
            },
            success: function (resp) {
                console.log("llego al php");
                var elementos = JSON.parse(resp);
                console.log("ajax devuelve: " + resp);
                console.log("el largo de los elementos es:" + elementos.length);
                console.log("json:" + elementos[0].top);
                for (i = 1; i <= elementos.length; i++) {
                    console.log("creo elemento:" + i);
                    VMFactory[i] = new VMproductoFactory();
                    productoFinal[i] = new producto(VMFactory[i]);
                    productoFinal[i].setIdelemento(elementos[i - 1].id_elemento);
                    productoFinal[i].setTop(elementos[i - 1].top);
                    productoFinal[i].setLeft(elementos[i - 1].lefts);
                    productoFinal[i].setHeight(elementos[i - 1].height);
                    productoFinal[i].setWidth(elementos[i - 1].width);
                    productoFinal[i].setIndex(elementos[i - 1].zIndex);
                    productoFinal[i].cambiarUrl(elementos[i - 1].img);
                    productoFinal[i].setTipo(elementos[i - 1].tipo);
                    productoFinal[i].setTexto(elementos[i - 1].texto);
                    tamaño = elementos[i - 1].tamano_letra;
                    tamaño = tamaño.split("%");
                    productoFinal[i].setTamaño(tamaño[0]);
                    var div = productoFinal[i].crearDOM();
                    var nuevoElemento = $(div);
                    nuevoElemento.draggable();
                    nuevoElemento.resizable();
                    $(document.body).append(nuevoElemento);
                }
            }
        });
        function configuracion(id) {

            var id_empresa = <?php echo $id_empresa; ?>;
            $(".idpermanente").attr("id", "guardar" + id);
            $("#tabla_aplicaciones").empty();
            var res = id.split("_");
            var m = res[1];
            var data = 'id_elemento=' + m + '&id_empresa=' + id_empresa;
            $.ajax({
                url: 'Ajax/configuracion.php',
                type: 'post',
                data: data,
                beforeSend: function () {
                    console.log('obteniendo parametros....')
                },
                success: function (resp) {
                    console.log(resp);
                    var elementos = JSON.parse(resp);
                    $("#elemntconfig").remove();
                    $("#tituloConfig").append('<input id="elemntconfig" type="text" name="elemento" value="' + m + '" disabled="disabled">');
                    for (i = 0; i < elementos.length; i++) {
                        $('#tabla_aplicaciones').append('<div class="row" style="display:block;" id="fila' + i + '"><input id="id_app' + i + '" type="text" value="" visible="false" style="display: none;"><input id="id' + i + '" type="text" value="' + m + '" visible="false" style="display: none;"><div class="col-md-2"><select class="form-control" id="tablami' + i + '"></select></div><div class="col-md-2"><input id="idmi' + i + '" class="form-control" type="text" value="' + elementos[i].id + '" visible="false" style="display: block;"></div><div class="col-sm-1"></div><div class="col-sm-1"><img id="div_' + i + '" onclick="deleteApp(id);" style="width: 45%; cursor:pointer;"src="imagenes/trash.png" alt=""></div></div>');
                        for (x = 0; x < elementos[0].aplicaciones.length; x++) {
                            $("#tablami" + i).append('<option value="' + elementos[0].aplicaciones[x].id_aplicacion + '">' + elementos[0].aplicaciones[x].aplicacion + '</option>');
                        }
                        $("#tablami" + i + " option[value='" + elementos[i].id_aplicacion + "']").attr("selected", true);
                    }

                }
            });
        }
        function deleteApp(id) {
            var res = id.split("_");
            var x = res[1];
            id_elemento = $("#id" + x + "").val();
            id_sensor = $("#id_sensor" + x + "").val();
            id_aplicacion = $("#id_app" + x + "").val();
            var data = 'id_elemento=' + id_elemento + '&id_sensor=' + id_sensor + '&id_aplicacion=' + id_aplicacion;
            $.ajax({
                url: 'Ajax/eliminarApp.php',
                type: 'post',
                data: data,
                beforeSend: function () {
                    console.log('obteniendo parametros....')
                },
                success: function (resp) {
                    $("#fila" + x + "").css("display", "none");
                    //$("#fila"+x+"").remove();
                }
            });

        }
        function addApp(id) {
            var id_empresa = <?php echo $id_empresa; ?>;
            var n = $("#tabla_aplicaciones div").length;
            i = n / 5;
            $.ajax({
                url: 'Ajax/configuracion.php',
                type: 'post',
                data: data,
                beforeSend: function () {
                    console.log('obteniendo parametros....')
                },
                success: function (resp) {
                    console.log(resp);
                    var elementos = JSON.parse(resp);
                    $('#tabla_aplicaciones').append('<div class="row" style="display:block;" id="fila' + i + '"><input id="id_app' + i + '" type="text" value="" visible="false" style="display: none;"><input id="id' + i + '" type="text" value="" visible="false" style="display: none;"><div class="col-md-2"><select class="form-control" id="tablami' + i + '"></select></div><div class="col-md-2"><input id="idmi' + i + '" class="form-control" type="text" value="" visible="false" style="display: block;"></div><div class="col-sm-1"></div><div class="col-sm-1"><img id="div_' + i + '" onclick="deleteApp(id);" style="width: 45%; cursor:pointer;"src="imagenes/trash.png" alt=""></div></div>');
                    for (x = 0; x < elementos[0].aplicaciones.length; x++) {
                        $("#tablami" + i).append('<option value="' + elementos[0].aplicaciones[x].id_aplicacion + '">' + elementos[0].aplicaciones[x].aplicacion + '</option>');
                    }
                    /*for (x = 0; x < elementos[0].aplicaciones.length; x++){
                     $("#id_aplicacion"+i).append('<option value="'+elementos[0].aplicaciones[x].aplicacion+'">'+elementos[0].aplicaciones[x].aplicacion+'</option>');
                     }
                     $("#id_aplicacion"+i+" option[value='"+elementos[i].aplicacion+"']").attr("selected", true);*/
                    $("#tablami" + i + " option[value='" + elementos[i].id_aplicacion + "']").attr("selected", true);
                }
            });
        }
        function saveApp(id) {
            var elementos = new Array();
            var res = id.split("_");
            var id = res[1];
            var id_empresa = <?php echo $id_empresa; ?>;
            var data = 'id_empresa=' + id_empresa;
            var n = $("#tabla_aplicaciones div").length;
            var i = n / 5;
            for (x = 0; x < i; x++) {
                var vision = $("#fila" + x + "").css("display");
                if (vision != 'none') {
                    var elemento = new Object();
                    elemento.idapp = $('select[id=tablami' + x + ']').val();
                    elemento.id = $('#idmi' + x + '').val();
                    elemento.id_elemento = id;
                    elementos.push(elemento);

                }
            }
            var elem = JSON.stringify(elementos);
            var data = 'elemento=' + elem;
            $.ajax({
                url: 'Ajax/guardarApp.php',
                type: 'post',
                data: data,
                beforeSend: function () {
                    console.log('obteniendo parametros....')
                },
                success: function (resp) {
                    swal("Guardado!", "", "success")
                }
            });
        }
        function agregarElemento() {
            var valvula = new productoFactory();
            console.log("\n building... \n");
            console.log("Creando valvula...");
            productoFinal[i] = valvula.crearComponent(id_empresa, 0);
            var div = productoFinal[i].crearDOM();
            var nuevoElemento = $(div);
            nuevoElemento.draggable();
            nuevoElemento.resizable();
            $(document.body).append(nuevoElemento);
            i = i + 1;
        }
        function agregarElemento2() {
            var valvula = new productoFactory();
            console.log("\n building... \n");
            console.log("Creando valvula...");
            productoFinal[i] = valvula.crearComponent(id_empresa, 1);
            var div = productoFinal[i].crearDOM();
            var nuevoElemento = $(div);
            nuevoElemento.draggable();
            nuevoElemento.resizable();
            $(document.body).append(nuevoElemento);
            i = i + 1;
        }
        function agregarElemento3() {
            var valvula = new productoFactory();
            console.log("\n building... \n");
            console.log("Creando valvula...");
            productoFinal[i] = valvula.crearComponent(id_empresa, 2);
            var div = productoFinal[i].crearDOM();
            var nuevoElemento = $(div);
            nuevoElemento.draggable();
            nuevoElemento.resizable();
            $(document.body).append(nuevoElemento);
            i = i + 1;
        }
        function agregarElemento4() {
            var valvula = new productoFactory();
            console.log("\n building... \n");
            console.log("Creando valvula...");
            productoFinal[i] = valvula.crearComponent(id_empresa, 3);
            var div = productoFinal[i].crearDOM();
            var nuevoElemento = $(div);
            nuevoElemento.draggable();
            nuevoElemento.resizable();
            $(document.body).append(nuevoElemento);
            i = i + 1;
        }
        function eliminarElemento(id) {
            var res = id.split("_");
            var x = res[1];
            console.log("este es el largo del arrelgo:" + i);
            for (p = 1; p < i; p++) {
                if (productoFinal[p] != null) {
                    console.log("objeto:" + productoFinal);
                    id_elemento = productoFinal[p].getIdelemento();
                    console.log("id_elemento:" + id_elemento);
                    if (x == id_elemento) {
                        productoFinal[p].destruirDOM();
                        var y = document.getElementById("dom_" + x);
                        y.remove(y.selectedIndex);
                        productoFinal[p] = null;
                    }
                }
            }
            console.log(productoFinal);
        }

        function guardarElemento() {
            console.log('entre a guardar elemento');
            console.log(productoFinal);
            var indice = productoFinal.length - 1;
            for (m = 1; m < i; m++) {
                if (productoFinal[m] != null) {
                    console.log("-------");
                    id_elemento = productoFinal[m].getIdelemento();
                    top1 = document.getElementById('dom_' + id_elemento).style.top;
                    left1 = document.getElementById('dom_' + id_elemento).style.left;
                    width1 = document.getElementById('dom_' + id_elemento).style.width;
                    height1 = document.getElementById('dom_' + id_elemento).style.height;
                    zIndex1 = document.getElementById('dom_' + id_elemento).style.zIndex;
                    tipo = productoFinal[m].getTipo();
                    if (tipo == 3) {
                        tamaño = document.getElementById('l_' + id_elemento).style.fontSize;
                        texto = $("#l_" + id_elemento).val();
                        productoFinal[m].setTamaño(tamaño);
                        productoFinal[m].setTexto(texto);
                    }
                    productoFinal[m].setTop(top1);
                    productoFinal[m].setTop(top1);
                    productoFinal[m].setLeft(left1);
                    productoFinal[m].setWidth(width1);
                    productoFinal[m].setHeight(height1);
                    productoFinal[m].setIndex(zIndex1);
                }
            }
            var producto1 = new productoFactory();
            producto1.guardarComponent(productoFinal);
            swal("Guardado!", "", "success")
        }
        function cambiarUrlImagen(id) {
            var res = id.split("_");
            var x = res[1];
            swal({
                title: "Nueva Imagen",
                text: "Ingrese la url de la imagen",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("necesita escribir algo");
                            return false
                        }
                        for (p = 1; p < i; p++) {
                            id_elemento = productoFinal[p].getIdelemento();
                            console.log("id_elemento:" + id_elemento);
                            if (x == id_elemento) {
                                productoFinal[p].cambiarUrl(inputValue);
                                var y = document.getElementById("dom_" + x);
                                y.remove(y.selectedIndex);
                                var div = productoFinal[p].crearDOM();
                                var nuevoElemento = $(div);
                                nuevoElemento.draggable();
                                nuevoElemento.resizable();
                                $(document.body).append(nuevoElemento);
                                swal("Bien", "Su url a cambiado a: " + inputValue, "success");
                            }
                        }
                    });
        }
        function elementoimg(id){
            document.getElementById("elementoimg").value = id;
        }
        function guardarImg(id){
           id = document.getElementById("elementoimg").value;
           img = document.getElementById("inputimg").value;
           inputImgDown = document.getElementById("inputImgDown").value;
           inputImgUp = document.getElementById("inputImgUp").value;
           inputImgNeutral = document.getElementById("inputImgNeutral").value;
           var data = 'id_elemento=' + id;
           var data = 'id_elemento=' + id + '&img=' + img + '&inputImgDown=' + inputImgDown + '&inputImgUp=' + inputImgUp + '&inputImgNeutral=' + inputImgNeutral;
            $.ajax({
                url: 'Ajax/imagenes_umbrales.php',
                type: 'post',
                data: data,
                beforeSend: function () {
                    console.log('obteniendo parametros....')
                },
                success: function (resp) {
                    console.log(resp)
                    swal("Guardado!", "", "success")
                }
            });
        }
        function cambiarUrlImagen(id) {
            var res = id.split("_");
            var x = res[1];
            swal({
                title: "Nueva Imagen",
                text: "Ingrese la url de la imagen",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("necesita escribir algo");
                            return false
                        }
                        for (p = 1; p < i; p++) {
                            id_elemento = productoFinal[p].getIdelemento();
                            console.log("id_elemento:" + id_elemento);
                            if (x == id_elemento) {
                                productoFinal[p].cambiarUrl(inputValue);
                                var y = document.getElementById("dom_" + x);
                                y.remove(y.selectedIndex);
                                var div = productoFinal[p].crearDOM();
                                var nuevoElemento = $(div);
                                nuevoElemento.draggable();
                                nuevoElemento.resizable();
                                $(document.body).append(nuevoElemento);
                                swal("Bien", "Su url a cambiado a: " + inputValue, "success");
                            }
                        }
                    });
        }
        function zIndex(id) {
            var res = id.split("_");
            var x = res[1];
            swal({
                title: "Nuevo zIndex",
                text: "Ingrese el zIndex de la imagen",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("necesita escribir algo");
                            return false
                        }
                        for (p = 1; p < i; p++) {
                            id_elemento = productoFinal[p].getIdelemento();
                            console.log("id_elemento:" + id_elemento);
                            if (x == id_elemento) {
                                productoFinal[p].setIndex(inputValue);
                                var y = document.getElementById("dom_" + x);
                                y.remove(y.selectedIndex);
                                var div = productoFinal[p].crearDOM();
                                var nuevoElemento = $(div);
                                nuevoElemento.draggable();
                                nuevoElemento.resizable();
                                $(document.body).append(nuevoElemento);
                                swal("Bien", "Su url a cambiado a: " + inputValue, "success");
                            }
                        }
                    });
        }
        function Tamaño(id) {
            var res = id.split("_");
            var x = res[1];
            swal({
                title: "Tamaño de letra",
                text: "Ingrese el tamaño de letra",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("necesita escribir algo");
                            return false
                        }
                        for (p = 1; p < i; p++) {
                            id_elemento = productoFinal[p].getIdelemento();
                            console.log("id_elemento:" + id_elemento);
                            if (x == id_elemento) {
                                productoFinal[p].setTamaño(inputValue);
                                var y = document.getElementById("dom_" + x);
                                y.remove(y.selectedIndex);
                                var div = productoFinal[p].crearDOM();
                                var nuevoElemento = $(div);
                                nuevoElemento.draggable();
                                nuevoElemento.resizable();
                                $(document.body).append(nuevoElemento);
                                swal("Bien", "Su url a cambiado a: " + inputValue, "success");
                            }
                        }
                    });
        }
        function popup(id, event) {

            if ($("#info").length) {
                return;
            }
            var data = 'id_elemento=' + id;
            $.ajax({
                url: 'Ajax/elementos_aplicacion.php',
                type: 'post',
                data: data,
                beforeSend: function () {
                    console.log('obteniendo parametros....')
                },
                success: function (resp) {
                    console.log(resp);
                    var sensores = JSON.parse(resp);
                    $("#infoline").append('<div id="info" style="border-radius: 27px;padding: 15px;text-align: left;" class="info"><img onclick="erasepopup()" style="float:right;width:5%;height:5%;cursor: pointer;" src="imagenes/cancelar.png"></div>');
                    for (i = 0; i < sensores.length; i++) {
                        aplicaciones = "";
                        for (x = 0; x < sensores[i].id_aplicacion.length; x++) {
                            if (sensores[i].tipo != 2) {
                                url = sensores[i].id_aplicacion[x].url;
                                icono = sensores[i].id_aplicacion[x].icono;
                                aplicaciones = aplicaciones + '<a href="' + url + '"><img style="width:10px;" src="imagenes/' + icono + '"></a>';
                            } else if (sensores[i].tipo == 2) {
                                url = sensores[i].id_aplicacion[x].url;
                                icono = sensores[i].id_aplicacion[x].icono;
                                aplicaciones = aplicaciones + '<form  method="post" target="_blank id="myform" action="' + url + '"><input  name="id_empresa" id="id_empresa" type="text" value="' + sensores[i].id_empresa + '" visible="false" style="display:none"><input  name="id_nodo" id="id_nodo" type="text" value="' + sensores[i].id_nodo + '" visible="false" style="display: none;"><input  name="equipo" id="equipo" type="text" value="' + sensores[i].id_equipo + '" visible="false" style="display: none;"><input type=image src="imagenes/' + icono + '" width="10px"></form>';
                            }
                        }
                        $("#info").append('<table><tr><td style="width:150px;"><strong><img style="width: 15px;"src="imagenes/analytics.png"></strong> ' + sensores[i].descripcion + '</td><td style="width:120px">' + sensores[i].valor + ' ' + sensores[i].unidad + '</td><td>' + aplicaciones + '</td></tr></table>');
                    }
                    x = event.clientX;
                    y = event.clientY;
                    document.getElementById('info').style.left = x + "px";
                    document.getElementById('info').style.top = y + "px";
                    document.getElementById('info').style.position = 'absolute';
                    document.getElementById("info").style.width = '423px';
                    document.getElementById("info").style.backgroundColor = 'white';
                    document.getElementById("info").style.borderStyle = 'solid';
                    document.getElementById("info").style.borderColor = 'rgb(0, 119, 255);';
                    document.getElementById("info").style.borderWidth = '1px';
                    document.getElementById("info").style.zIndex = '99';
                    document.getElementById("info").style.border.radius = '27px 27px 27px 27px';
                }
            });

        }
        function erasepopup() {
            $(".info").remove();
        }


        function importar() {
            swal({
                title: "Nueva Imagen",
                text: "Ingrese la url de la imagen",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            },
                    function (inputValue) {
                        if (inputValue === false) {
                            return false;
                        }
                        if (inputValue === "") {
                            swal.showInputError("necesita escribir algo");
                            return false
                        }
                        id = document.getElementById("elemntconfig").value;
                        var data = 'id_elemento=' + inputValue + '&id_elementoOriginal=' + id;
                        $.ajax({
                            url: 'Ajax/import.php',
                            type: 'post',
                            data: data,
                            beforeSend: function () {
                                console.log('obteniendo parametros....')
                            },
                            success: function (resp) {
                                console.log(resp);
                                swal("Bien", "import desde el nodo" + id + "success");
                            }});
                    });
        }
    </script>
    <body>
        <!-- NAVBAR -->
        <div id="herramientas">
            <ul class="nav navbar-nav">
                <li style="width: 52px;height: 60px;"><img onclick="agregarElemento()" title="agregar nodo" id="nodo" src="imagenes/lapiz.png" alt="agregar Elemento"></li>
                <li style="width: 52px;height: 60px;"><img onclick="agregarElemento2()" title="agregar tubo" id="nodo" src="imagenes/glass_of_water.png" alt="agregar Elemento Agua"></li>
                <li style="width: 52px;height: 60px;"><img onclick="agregarElemento3()" title="agregar tubo" id="nodo" src="imagenes/gauge.png" alt="agregar Elemento Valor"></li>
                <li style="width: 52px;height: 60px;"><img onclick="agregarElemento4()" title="agregar tubo" id="nodo" src="imagenes/label.png" alt="agregar Elemento Valor"></li>
                <li style="width: 52px;height: 60px;"><img onclick="guardarElemento()" title="guardar" id="nodo" src="imagenes/save.png" alt="guardar"></li>
            </ul>
        </div>
        <!-- ************************************************************************************************************************************************************************************** -->
        <div id="infoline"></div>
        <!-- Form to index element and app-->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog" style="width: 45%;">			
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" id="tituloConfig">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Configuracion</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container" id="tabla_aplicaciones"> 

                            </div>
                        </div>
                        <div class="modal-footer">
                            <img title="import" id="import" onclick="importar();" style="width: 6%; cursor:pointer;"src="imagenes/import.png" alt="guardar">
                            <img title="guardar" id="agregar" onclick="addApp();" style="width: 6%; cursor:pointer;"src="imagenes/plus.png" alt="guardar">
                            <img title="guardar" class="idpermanente" id="guardar" onclick="saveApp(id);" style="width: 6%; cursor:pointer;"src="imagenes/diskette.png" alt="guardar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- *************************************************************************************************************************************************************************************** -->
        <!-- Form to index element and app-->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="myModal2" role="dialog">
                <div class="modal-dialog" style="width: 45%;">			
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" id="tituloConfig">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Imagenes</h4>
                            <input style="display: none" type="text" class="form-control" id="elementoimg" placeholder="" value="">
                        </div>
                        <div class="modal-body">
                            <div class="container" id="tabla_img"> 
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="inputimg" class="col-sm-2 control-label">Imagen original</label>
                                        <div class="col-sm-10">
                                            <input style="width: 180px;" type="text" class="form-control" id="inputimg" placeholder="imagenes/img.png">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputImgDown" class="col-sm-2 control-label">Imagen bajo el umbral</label>
                                        <div class="col-sm-10">
                                            <input style="width: 180px;" type="text" class="form-control" id="inputImgDown" placeholder="imagenes/img.png">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputImgUp" class="col-sm-2 control-label">Imagen sobre el umbral</label>
                                        <div class="col-sm-10">
                                            <input style="width: 180px;" type="text" class="form-control" id="inputImgUp" placeholder="imagenes/img.png">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputImgNeutral" class="col-sm-2 control-label">Imagen entre el umbral</label>
                                        <div class="col-sm-10">
                                            <input style="width: 180px;" type="text" class="form-control" id="inputImgNeutral" placeholder="imagenes/img.png">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <img title="guardar" class="idpermanente" id="guardar" onclick="guardarImg();" style="width: 6%; cursor:pointer;"src="imagenes/diskette.png" alt="guardar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- *************************************************************************************************************************************************************************************** -->
    </body>
</html>
