<nav id="conmenu"><!-- la etiqueta nav es para el menu de navegacion.-->
		<ul class="menu"><!--la etiqueta ul es el contenedor de una lista-->
		<li><a href=agenda.php>Agenda</a></li><!--la etiqueta li es cada campo de la lista -->
		<li><a href=agregar.php>Agregar persona</a></li><!--la etiqueta a, es la que define el hipervinculo -->
	</ul>
</nav>	

<label> <h3> Agenda </h3> </label>

<form method="post">
	<table id="caja" cellpadding="2" cellspacing="2" border="1">
		<tr>
			<td>Buscar persona por nombre</th>
			<td><label for="nombre"></label><input type="text" name="buscar_persona" placeholder="nombre"></td>
			<td><input type="submit" name="submitFind" value="Buscar"></td>		
		</tr>
	
	</table>
</form>
<?php

$url = "agenda.php";

// importa el archivo para poder llamar sus metodos mas adelante
require 'simplexml.class.php';
//dentro del arreglo $listen cargamos las personas almacenadas en el archivo xml
$listin = simplexml_load_file('listin.xml');

if(isset($_POST['submitFind']))
{ 	
	$nombre_form = strtoupper((string)$_POST['buscar_persona']);
	
	foreach ($listin->persona as $persona)
	{	
		$nombre_xml = strtoupper((string)$persona ->nombre);
		
		if($nombre_form == $nombre_xml)
		{
			
			?>

				<table id="caja" cellpadding="2" cellspacing="2" border="2">
					<tr>
						<th>Id</th>
						<th>Sexo</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Option</th>
					</tr>
					
					<tr id=busqueda>
						<td><?php echo $persona ['id']; ?></td>
						<td><?php echo $persona ['sexo']; ?></td>
						<td><?php echo $persona ->nombre; ?></td>
						<td><?php echo $persona ->email; ?></td>		
						<!--en la ultima celda se ubica los icono asociados a editar y eliminar con sus respectivas acciones-->
						<td align="center">
						<a  href="edit.php?id=<?php echo $persona['id']; ?>"><img src="edit.png"></a> | 
						<a href="agenda.php?action=delete&id=<?php echo $persona['id']; ?>"
						onclick="return confirm('estas seguro de eliminar el usuario')"><img src="delete.png"></a></td>
						</td>	
					</tr>
				
			<?php
			
			
		}			
	}
}

?>



<table id="caja" cellpadding="2" cellspacing="2" border="1">
	<tr>
		<th>Id</th>
		<th>Sexo</th>
		<th>Nombre</th>
		<th>Email</th>
		<th>Option</th>
	</tr>
	
<?php 
	
	$listin = simplexml_load_file('listin.xml');
	//imprime la cantidad de datos que tiene el arreglo $listin
	$total=count($listin);
	echo '<h3> Cantidad de personas guardadas: '.$total.'</h3>';
	

	 if($total>0){
	   //Limito la busqueda
	 
		$tamanio_pagina = 5;
		$pagina = false;
		
		//examino la página a mostrar y el inicio del registro a mostrar
		if (isset($_GET["pagina"]))
          $pagina = $_GET["pagina"];
		
		if (!$pagina) {
		   $tope = 5;
		   $inicio = 0;
		   $pagina = 1;
		}
		else {
			if ($pagina == 1) {
				$inicio = 0;
				$tope = 5;
			} else {
			
				$inicio = ($pagina - 1) * $tamanio_pagina;
				$tope = ($pagina-1) * 5;
				if (($tope+5) > $total) {
					$tope = $tope + ($total - $tope);
				} else {
					$tope = $tope+5;
				}
				
			}
			
		}
		//calculo el total de páginas
		$total_paginas = ceil($total / $tamanio_pagina);
		for($i = $inicio; $i < $tope; $i++)
		{
			$persona = $listin->persona[$i]; 	
			?>
			<tr>
				<td><?php echo $persona ['id']; ?></td>
				<td><?php echo $persona ['sexo']; ?></td>
				<td><?php echo $persona ->nombre; ?></td>
				<td><?php echo $persona ->email; ?></td>		
				<!--en la ultima celda se ubica los icono asociados a editar y eliminar con sus respectivas acciones-->
				<td align="center">
				<a  href="edit.php?id=<?php echo $persona['id']; ?>"><img src="edit.png"></a> | 
				<a href="agenda.php?action=delete&id=<?php echo $persona['id']; ?>"
				onclick="return confirm('estas seguro de eliminar el usuario')"><img src="delete.png"></a></td>
				</td>	
			</tr>
		
			<?php
		}
?>
	
</table>


<p>
<?php
	if ($total_paginas > 1) {
		if ($pagina != 1)
			echo '<a href="'.$url.'?pagina='.($pagina-1).'"><img src="izq.gif" border="0"></a>';
		for ($i=1;$i<=$total_paginas;$i++) {
			if ($pagina == $i)
				//si muestro el �ndice de la p�gina actual, no coloco enlace
				echo $pagina;
			else
				//si el �ndice no corresponde con la p�gina mostrada actualmente,
				//coloco el enlace para ir a esa p�gina
				echo '  <a href="'.$url.'?pagina='.$i.'">'.$i.'</a>  ';
		}
		if ($pagina != $total_paginas)
			echo '<a href="'.$url.'?pagina='.($pagina+1).'"><img src="der.gif" border="0"></a>';
	}
	?>
</p>
	<?php
	}
	
?>
	
<?php
// el usuario afectua una accion, para este caso la accion es oprimir el icono de 
// eliminar dentro de la tabla que muestra todas las personas que estan dentro del xml 
if(isset($_GET['action']))
{
	//dentro del arreglo $listen cargamos las personas almacenadas en el archivo xml
	$listin = simplexml_load_file('listin.xml');
	//almacena el identificador de la persona que comprtia la fila con el icono de eliminar
	$id = $_GET['id'];
	//variables para almacenar la posicion en el arreglo $listin que ocupa la persona a eliminar
	$agenda = 0;
	$i = 0;
	//recorremos el arreglo listen sacando una elemento a la vez
	foreach ($listin->persona as $persona)
	{
		//si el id del elemento actual coincide con el valor almacenado en $id
		if($persona['id']==$id )
		{
			//almacena el valor del identificador en la variable $agenda
			$agenda = $i;
			//rompe el ciclo
			break;
		}
		$i++;
	}
	// dentro del arreglo $listin se limpia la entrada correspondiente al valor $agenda
	unset ($listin->persona[$agenda]);
	//escribe dentro del archivo listin.xml el nuevo contenido del arreglo $listin
	file_put_contents('listin.xml', $listin->asXML());
	
	header('Location: agenda.php');
	// tolima armero trabajo ganaderia agro
}
?>


<style>
	p{
		font-family: Open Sans-serif;
		color: white; 
	}

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
	tr#busqueda 
	{
		background: rgba(45, 228, 13, 0.18);
	}
	table#caja 
	{
		background: rgba(128, 128, 128, 0.5);
		width: 90%;
		margin: auto;
		border: 1px solid #ddd;
		margin-bottom: 20px;
		font-family: Open Sans-serif;
		margin-top: 20px;
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

