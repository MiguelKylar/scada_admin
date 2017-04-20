/*Implements: BicyclePartsFactory*/
class VMproductoFactory{
	constructor(){
	/*Type: Numbre*/this._idelemento;
	/*Type: Numbre*/this._top;
	/*Type: Numbre*/this._left;
	/*Type: Numbre*/this._heigth;
	/*Type: Numbre*/this._width;
	/*Type: Numbre*/this._img = "imagenes/valvulamariposa.png";
	}
	
	/*Return: Class Cuadro*/
	obtenerParametros(id_empresa,id_tipo) {
		    console.log("ajax tipo"+id_tipo);
			var resultadoGlobal="";
			var data = 'id_empresa=' + id_empresa  + '&id_tipo=' + id_tipo;
		    console.log("entre a obtener...");
			$.ajax({
                url: 'Ajax/obtenerParametrosVM.php',
                type: 'post',
				async: false,
				data: data,
                beforeSend: function () {
                    console.log('enviando....'+id_empresa)
                },
                success: function (resp) {	
				resultadoGlobal=resp;
				console.log("obtuve...");
                }
            });
			this._idelemento = resultadoGlobal;
			console.log("sali de obtener...");
		
	}
	eliminarParametros(id_elemento) {
		    console.log("entre a eliminar...");
		    var data = 'id_elemento=' + id_elemento;
			$.ajax({
                url: 'Ajax/eliminarParametrosVM.php',
                type: 'post',
				async: false,
				data: data,
                beforeSend: function () {
                    console.log('enviando...')
                },
                success: function (resp) {	
				console.log("elimine...");
                }
            });
			console.log("sali de eliminar...");
		
	}
	getIdelemento(){
		console.log("entre a getidnodo");
		console.log(this._idelemento);
		return this._idelemento;
	}
		getImg(){
		return this._img;
	}
}
