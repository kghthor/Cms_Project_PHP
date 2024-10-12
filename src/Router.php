<?php
namespace Project\Cms;

class Router {
    // Array to store route mappings
    private $routes = [];

    // Add a route to the router
    // Parameters:
    // - $route: The route URL (e.g., 'user')
    // - $controllerAction: The controller and method to handle this route (e.g., 'UserController@welcome')
    public function add($route, $controllerAction) {
        $this->routes[$route] = $controllerAction;
    }

    // Dispatch a request to the appropriate controller/action
    // Parameters:
    // - $requestedRoute: The route URL requested by the user (e.g., 'user')
    public function dispatch($requestedRoute) {
        // Check if the requested route exists in the routes array
        if (array_key_exists($requestedRoute, $this->routes)) {
            // Get the controller and method for the requested route
            $controllerAction = $this->routes[$requestedRoute];
            // Split the controller and method using '@' as delimiter
            list($controller, $method) = explode('@', $controllerAction);
            
            {
                // Build the fully qualified class name
                $class = "Project\\Cms\\$controller";
                
                // Check if the class exists
                if (class_exists($class)) {
                    // Create an instance of the class
                    $instance = new $class();
                    // Check if the method exists in the class
                    if (method_exists($instance, $method)) {
                        // Call the method
                        $instance->$method();
                    } else {
                        // Method not found
                        die("Method $method not found in $class");
                    }
                } else {
                    // Class not found
                    die("Class $controller not found");
                }
            }
        } else {
            // Route not defined
            die("Route $requestedRoute not defined");
        }
    }
}
