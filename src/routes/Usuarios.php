<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Get All Customers
$app->get('/api/Usuarios', function(Request $request, Response $response){
    $sql = "SELECT * FROM Usuarios";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single Customer
$app->get('/api/Usuarios/{ID}', function(Request $request, Response $response){
    $ID = $request->getAttribute('ID');

    $sql = "SELECT * FROM Usuarios WHERE ID = $ID";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $Usuarios = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($Usuarios);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add Customer
$app->post('/api/Usuarios/Agregar', function(Request $request, Response $response){
    $Primer_Nombre = $request->getParam('Primer_Nombre');
    $Primer_Apellido = $request->getParam('Primer_Apellido');
    $Telefono = $request->getParam('Telefono');
    $Correo = $request->getParam('Correo');
    $Direccion = $request->getParam('Direccion');
    $Ciudad = $request->getParam('Ciudad');
    $Departamente = $request->getParam('Departamente');

    $sql = "INSERT INTO `Usuarios` (`ID`, `Primer_Nombre`, `Primer_Apellido`, `Telefono`, `Correo`, `Direccion`, `Ciudad`, `Departamente`) VALUES
    (`ID`, `Primer_Nombre`, `Primer_Apellido`, `Telefono`, `Correo`, `Dirección`, `Ciudad`, `Departamente`)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Primer_Nombre', $Primer_Nombre);
        $stmt->bindParam(':Primer_Apellido',  $Primer_Apellido);
        $stmt->bindParam(':Telefono',      $Telefono);
        $stmt->bindParam(':Correo',      $Correo);
        $stmt->bindParam(':Direccion',    $Direccion);
        $stmt->bindParam(':Ciudad',       $Ciudad);
        $stmt->bindParam(':Departamente',      $Departamente);

        $stmt->execute();

        echo '{"notice": {"text": "Usuario agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update Customer
$app->put('/api/Usuarios/Actualizar/{ID}', function(Request $request, Response $response){
    $ID = $request->getAttribute('ID');
    $Primer_Nombre = $request->getParam('Primer_Nombre');
    $Primer_Apellido = $request->getParam('Primer_Apellido');
    $Telefono = $request->getParam('Telefono');
    $Correo = $request->getParam('Correo');
    $Direccion = $request->getParam('Direccion');
    $Ciudad = $request->getParam('Ciudad');
    $Departamente = $request->getParam('Departamente');

    $sql = "UPDATE Usuarios SET
				Primer_Nombre 	= :Primer_Nombre,
				Primer_Apellido 	= :Primer_Apellido,
                Telefono		= :Telefono,
                Correo		= :Correo,
                Direccion 	= :Direccion,
                Ciudad 		= :Ciudad,
                Departamente		= :Departamente
			WHERE ID = $ID";

	
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Primer_Nombre', $Primer_Nombre);
        $stmt->bindParam(':Primer_Apellido',  $Primer_Apellido);
        $stmt->bindParam(':Telefono',      $Telefono);
        $stmt->bindParam(':Correo',      $Correo);
        $stmt->bindParam(':Direccion',    $Direccion);
        $stmt->bindParam(':Ciudad',       $Ciudad);
        $stmt->bindParam(':Departamente',      $Departamente);

        $stmt->execute();

        echo '{"notice": {"text": "Usuario actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete Customer
$app->delete('/api/Usuarios/Borrar/{ID}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM Usuarios WHERE id = $ID";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Usuario Borrado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
