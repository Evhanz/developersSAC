<?php
// Routes

/*
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
*/

$app->get('/allEmployes', function ($request, $response, $args) {


    $path_file = __DIR__ . '/../src/employees.json';

    $data = file_get_contents($path_file);
    $employees = json_decode($data, true);

    $args['employees'] = $employees;

    //var_dump($employees);


    // Render index view
   return $this->renderer->render($response, 'employes.phtml', $args);
});

$app->post('/allEmployes', function ($request, $response, $args) {


    $path_file = __DIR__ . '/../src/employees.json';

    $data = file_get_contents($path_file);
    $employees = json_decode($data, true);

    $email = $_POST['email'];
    $res = [];

    foreach ($employees as $item){

        if($item['email'] == $email){
            array_push($res,$item);

        }

    }


    $args['employees'] = $res;

    // Render index view
    return $this->renderer->render($response, 'employes.phtml', $args);
});

$app->get('/employee/[{id}]', function ($request, $response, $args) {


    $path_file = __DIR__ . '/../src/employees.json';

    $data = file_get_contents($path_file);
    $employees = json_decode($data, true);

    $id = $args['id'];
    $res = '';

    foreach ($employees as $item){

        if($item['id'] == $id){
           $res = $item;

        }

    }

    $args['emp'] = $res;

    // Render index view
    return $this->renderer->render($response, 'emp_detail.phtml', $args);
});

$app->get('/api/employ_salary/{minimo}/{maximo}', function ($request, $response, $args) {


    $path_file = __DIR__ . '/../src/employees.json';

    $data = file_get_contents($path_file);
    $employees = json_decode($data, true);

    $minimo = $args['minimo'];
    $maximo = $args['maximo'];

    $res = [];

    foreach ($employees as $item){

        $salario = str_replace(['$',','],'',$item['salary']) ;

        if($salario >= $minimo && $salario <= $maximo ){
            array_push($res,$item);

        }

    }




    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="utf-8"?> ';
    echo '<employees>';
    foreach($res as $item) {
        echo '<employ>';
        if(is_array($item)) {
            echo '<name>',$item['name'],'</name>';
            echo '<email>',$item['email'],'</email>';
            echo '<phone>',$item['phone'],'</phone>';
            echo '<address>',$item['address'],'</address>';
            echo '<position>',$item['position'],'</position>';
            echo '<salary>',$item['salary'],'</salary>';
            echo '<skills>';
            foreach ($item['skills'] as $skill){
                echo '<skill>',$skill['skill'],'</skill>';
            };

            echo '</skills>';
        }
        echo '</employ>';
    }
    echo '</employees>';





});
