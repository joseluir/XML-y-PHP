<nav id="conmenu"><!-- la etiqueta nav es para el menu de navegacion.-->
		<ul class="menu"><!--la etiqueta ul es el contenedor de una lista-->
		<li><a href=agenda.php>Agenda</a></li><!--la etiqueta li es cada campo de la lista -->
		<li><a href=agregar.php>Agregar persona</a></li><!--la etiqueta a, es la que define el hipervinculo -->
	</ul>
</nav>	

<label> <h3> Agregar persona </h3> </label>


<form method="post">
	<table id="agregar" cellpadding="2" cellspacing="2">
		<tr>
			<td>Id</td>
			<td><input type="text" name="id" placeholder="id"></td>
		</tr>
		<tr>
			<td>sexo</td>
			<td>
				<select id="sexo" name="sexo">  <!--select sirve para almacenar una lista despegable.  -->
					<option value="masculino">Masculino</option><!--etiqueta option permite definir una lista de opciones -->
					<option value="femenino">Femenino</option>  
				</select>
			</td>
		</tr>
		<tr>
			<td>Nombre</td>
			<td><input type="text" name="nombre" placeholder="nombre"></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type="email" name="email" placeholder="email"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submitSave" value="Agregar"></td>
		</tr>
	</table>
</form>


<?php
// el susuario afectua un metodo tipo POST relacionado al boton submitSave 
if(isset($_POST['submitSave']))
{
	//dentro del arreglo $listen cargamos las personas almacenadas en el archivo xml
	$listin = simplexml_load_file('listin.xml');
	//
	$persona = $listin -> addChild('persona');
	//
	$persona ->addAttribute('id', $_POST['id']);
	$persona ->addAttribute('sexo', $_POST['sexo']);
	$persona ->addChild('nombre', $_POST['nombre']);
	$persona ->addChild('email', $_POST['email']);
	//escribe dentro del archivo listin.xml el contenido del arreglo $listin
	file_put_contents('listin.xml', $listin ->asXML());
	//
	header('Location: agenda.php');
}
?>



<style>
	body 
	{
		background-image: url("hermosa.jpg");
		text-align: center;
		color: white;
		font-family: Open Sans-serif;
		font-size: 20px;
	}
	
	
		nav#conmenu /* el tag nav significa navegacion en el cual se le a dado un id de nombre conmenu */
	{
	    /*background-image: url("../imagenes/madera5.jpg");  el menu tiene como fondo una imagen  */
	    width: 80%; /*  el ancho del menu */
	    border-radius: 20px; /* los bordes de el navegador tiene una redondes de 20px */
	    margin: auto; /* un magen de manera automatica */
	}
	/* la manera de leer la siguiente etiqueta es de derecha a izquierda  */
	/*  el contenedor ul con nombre menu, que esta en el nav con nobre conmenu */
	nav#conmenu ul.menu /* el contenedor ul el cual tiene como nombre de la clase menu, y el cual esta dentro del tag de la navegacion que toma como id conmenu */
	{
		background: transparent; /* fondo transparente  */
		border-radius: 10px;	/* darle un borde redondo a la caj */
		width: auto; /* tiene una anchura de manera automatica */
		
		list-style: none; /* no listar el menu */
		text-align: center; /* el texto que tiene el contenedor ul es aliniado de manera central */
		box-shadow: 0 0 20px;	/* campo con sombre */
	}
	nav#conmenu ul.menu li /* el campo de cada lista -li  que se encuentra en el ul de class menu, contenido en el navegador con un id conmenu*/
	{
		background: transparent;
		display: inline-block;/* enlinear de manera seguida, horizontal */
		margin: 10px; /* tiene un margen de 10 px   */
		font-family: fantasy;	/* tipo de letra*/
		font-size: larger; /* el tamaño de la fuente es de manera gruesa */
		color: white;/*color de la letra */
	}
	/* el hipervinculo contenido en la lista -li contenido en el navegador con un id conmenu  */
	nav#conmenu ul.menu li a
	{
		text-decoration: none; /* quitarle cualquier decoracion que le da automaticamente la etiqueta a */
		font-family: fantasy;  /* tipo de fuente */
		font-size: large;
		color: white;
	}

	
	form 
	{
		text-align: center;
		border-bottom-style: double;
		padding: 10px;
		border-top-style: double;
		margin: 20px;
	}
	table#agregar 
	{
		
		width: 50%;
		margin-left: 300px;
		padding: 20px;
	}
	input[type="text"] 
	{
		width: 300px;
		display: block;
		height: 34px;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}
	input[type="email"] 
	{
		width: 300px;
		display: block;
		height: 34px;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}
	td 
	{
		padding: 5px;
	}
	input[type="submit"] 
	{
		margin-left: 110px;
		box-shadow: 0 0 10px;
		height: 30px;
		background: rgba(255, 255, 255, 0.36);
		color: black;
	}
	table#caja 
	{
		background: rgba(128, 128, 128, 0.5);
		width: 90%;
		margin: auto;
		border: 1px solid #ddd;
		font-family: Open Sans-serif;
	}
	select#sexo 
	{
		width: 300px;
		display: block;
		height: 34px;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}
</style>

