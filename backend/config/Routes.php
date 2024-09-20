<?php

class Routes {

    public static function init($router) {
        $router->get('/task', function() {
            require_once "../controllers/TaskController.php";
            $taskController = new TaskController();
            $taskController->list(); 
        });

        $router->post('/task', function() {
            require_once "../controllers/TaskController.php";
            $taskController = new TaskController();
            $taskController->create(); 
        });

        $router->put('/task', function() {
            require_once "../controllers/TaskController.php";
            $taskController = new TaskController();
            $taskController->update(); 
        });

        
        /* $router->delete('/task', function() {
            require_once "../controllers/TaskController.php";
            $taskController = new TaskController();
            $taskController->delete();
        }); */

        $router->post('/login', function() {
            echo "Rota de login";
        });
    }
}