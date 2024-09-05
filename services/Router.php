<?php
    class Router {
        private array $routes;

        public function __construct() {
            $this->routes = [
                'GET' =>[
                    '/usuarios' => [ #ok
                        'controller' => 'UsuarioController',
                        'function' => 'getUsuarios'
                    ],
                    '/status' => [ #ok
                        'controller' => 'StatusController',
                        'function' => 'getStatus'
                    ],
                    '/produtos' => [ #ok
                        'controller' => 'ProdutoController',
                        'function' => 'getProduto'
                    ],
                    '/pedidos' => [ #ok
                        'controller' => 'PedidoController',
                        'function' => 'getPedido'
                    ]
                ],
                'POST' => [
                    '/buscar-usuario' => [ #ok
                        'controller' => 'UsuarioController',
                        'function' => 'getUsuarioS'
                    ],
                    '/cadastrar-usuario' => [ #ok
                        'controller' => 'UsuarioController',
                        'function' => 'createUsuario'
                    ],
                    '/buscar-status' => [ #ok
                        'controller' => 'StatusController',
                        'function' => 'getStatus'
                    ],
                    '/buscar-produto' => [  #ok
                        'controller' => 'ProdutoController',
                        'function' => 'getProduto'
                    ],
                    '/cadastrar-produto' => [ #ok
                        'controller' => 'ProdutoController',
                        'function' => 'createProduto'
                    ],
                    '/itens-pedido' => [ #ok
                        'controller' => 'ItemPedidoController',
                        'function' => 'getItemPedido'
                    ],
                    '/cadastrar-item-pedido' => [ #ok
                        'controller' => 'ItemPedidoController',
                        'function' => 'createItemPedido'
                    ],
                    '/buscar-pedido' => [ #ok
                        'controller' => 'PedidoController',
                        'function' => 'getPedido'
                    ],
                    '/cadastrar-pedido' => [ #ok
                        'controller' => 'PedidoController',
                        'function' => 'createPedido'
                    ],
                    '/buscar-pedido-pessoa' => [ #ok  
                        'controller' => 'PedidoController',
                        'function' => 'getPedidoPessoa'
                    ],
                    '/valor-total-pedido' => [ #ok 
                        'controller' => 'PedidoController',
                        'function' => 'buscarValorTotalPedido'
                    ]
                ],
                'PUT' => [
                    '/editar-usuario' => [ 
                        'controller' => 'UsuarioController',
                        'function' => 'updateUsuario'
                    ],
                    '/editar-item-pedido' => [
                        'controller' => 'ItemPedidoController',
                        'function' => 'updateItemPedido'
                    ],
                    '/editar-produto' => [
                        'controller' => 'ProdutoController',
                        'function' => 'updateProduto'
                    ],
                    '/editar-pedido' => [
                        'controller' => 'PedidoController',
                        'function' => 'updatePedido'
                    ],
                    '/editar-status-pedido' => [
                        'controller' => 'PedidoController',
                        'function' => 'updateStatusPedido'
                    ]
                ],
                'DELETE' => [
                    '/excluir-usuario' => [
                        'controller' => 'UsuarioController',
                        'function' => 'deleteUsuario'
                    ],
                    '/excluir-item-pedido' => [
                        'controller' => 'ItemPedidoController',
                        'function' => 'deleteItemPedido'
                    ],
                    '/excluir-produto' => [
                        'controller' => 'ProdutoController',
                        'function' => 'deleteProduto'
                    ],
                    '/excluir-pedido' => [
                        'controller' => 'PedidoController',
                        'function' => 'deletePedido'
                    ]
                ]
            ];
        }

        public function handaleRequest(string $method, string $route): string {
            $routeExists = !empty($this->routes[$method][$route]);

            if (!$routeExists) {
                return json_encode([
                    'error' => 'Essa rota não existe!',
                    'result' => null
                ]);
            }

            $routeInfo = $this->routes[$method][$route];

            $controller = $routeInfo['controller'];
            $function = $routeInfo['function'];

            require_once __DIR__. '/../controllers/' . $controller . '.php';

            return (new $controller)->$function();
        }
    }
?>