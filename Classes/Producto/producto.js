/*This is the product that is built*/
class producto{
	/*Input: Class BicyclePartsFactory*/
	constructor(productoPartFactory){
	/*Type: String*/this._dom;
	/*Type: Numbre*/this._idelemento;
	/*Type: Numbre*/this._top;
	/*Type: Numbre*/this._left;
	/*Type: Numbre*/this._heigth = '150';
	/*Type: Numbre*/this._width = '150';
	/*Type: String*/this._zIndex;
	/*Type: String*/this._img;
	/*Type: String*/this._tipo = 0;
	/*Type: String*/this._tamaño = '300';
	/*Type: String*/this._texto = 'texto';
	this.productoPartFactory = productoPartFactory;
	}
	/*Return: void*/

	//Metodos Sets////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	setIdelemento(id_elemento){
	/*Type: Numbre*/this._idelemento = id_elemento;
	}
	setTexto(texto){
	/*Type: Numbre*/this._texto = texto;
	}
	setTamaño(tamaño){
	/*Type: Numbre*/this._tamaño = tamaño;
	}
	setTop(tops){
	/*Type: Numbre*/this._top = tops;
	}
	setTipo(tipo){
	/*Type: Numbre*/this._tipo = tipo;
	}
	setLeft(lefts){
	/*Type: Numbre*/this._left = lefts;
	}
	setHeight(heigths){
	/*Type: Numbre*/this._heigth = heigths;	
	}
	setWidth(widths){
	/*Type: Numbre*/this._width = widths;	
	}
	setIndex(zIndex){
	/*Type: Numbre*/this._zIndex = zIndex;	
	}
	//Metodos Gets///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	getIdelemento(){
	return this._idelemento;	
	}
	getTexto(){
	return this._texto;	
	}
	getTop(){
	return this._top;
	}
	getLeft(){
	return this._left;
	}
	getHeight(){
	return this._heigth;	
	}
	getWidth(){
	return this._width;	
	}
	getIndex(){
	return this._zIndex;	
	}
	getTipo(){
	return this._tipo;	
	}
	getTamaño(){
	return this._tamaño;	
	}
	//Metodos Especiales////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	ensamblar(id_empresa,id_tipo){
	console.log("este es el tipo"+id_tipo);
	this.productoPartFactory.obtenerParametros(id_empresa,id_tipo);		
	this._idelemento = this.productoPartFactory.getIdelemento();
	this._img = this.productoPartFactory.getImg();
	this._tipo = id_tipo;
	}
	
	crearDOM(){
		if(this._tipo == 3){
		this._dom = "<div ondblclick='cambiarUrlImagen(id)' id='dom_"+this._idelemento+"' style='z-index:"+this._zIndex+";position:absolute;width:"+this._width+"px;height:"+this._heigth+"px;left:"+this._left+"px;top:"+this._top+"px;'><img id='x_"+this._idelemento+"' onclick='eliminarElemento(id)' style='width:10%;height:10%;cursor: pointer;' src='imagenes/cancelar.png'><img id='m_"+this._idelemento+"' onclick='Tamaño(id)' style='width:10%;height:10%;cursor: pointer;' src='imagenes/css.png'><input id='l_"+this._idelemento+"'; style='width:100%; font-size:"+this._tamaño+"%;' type='text' name='FirstName' value='"+this._texto+"'></div>";
		}else{
		this._dom = "<div ondblclick='cambiarUrlImagen(id)' id='dom_"+this._idelemento+"' style='z-index:"+this._zIndex+";position:absolute;width:"+this._width+"px;height:"+this._heigth+"px;left:"+this._left+"px;top:"+this._top+"px;'><img id='x_"+this._idelemento+"' onclick='eliminarElemento(id)' style='width:10%;height:10%;cursor: pointer;' src='imagenes/cancelar.png'><img data-toggle='modal' data-target='#myModal' id='y_"+this._idelemento+"' style='width:10%;height:10%;cursor: pointer;position:relative;' src='imagenes/settings.png' onclick='configuracion(id);'><img id='m_"+this._idelemento+"' onclick='zIndex(id)' style='width:10%;height:10%;cursor: pointer;' src='imagenes/css.png'><img onmouseleave=''  id='z_"+this._idelemento+"' style='border: black 2px solid; width: 100%;height: 90%;' src='"+this._img+"'></div>";
		}
		return this._dom;
	}
	destruirDOM(){
	this.productoPartFactory.eliminarParametros(this._idelemento);	
	}
	cambiarUrl(url){
		this._img = url;
	}
	cargarElementos(id_empresa){
	}
} 