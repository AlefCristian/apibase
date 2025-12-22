<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class MenuController extends BaseController
{
    public function index()
    {
        $menu = [
            [
                "label" => "Dashboard",
                "path"  => "/dashboard",
                "icon"  => "DashboardOutlined",
            ],
            [
                "label" => "Cadastros",
                "icon"  => "AppstoreOutlined",
                "children" => [
                    [
                        "label" => "Clientes",
                        "path"  => "/clientes",
                        "icon"  => "UserOutlined",
                    ],
                    [
                        "label" => "Produtos",
                        "path"  => "/produtos",
                        "icon"  => "TagOutlined",
                    ]
                ]
            ],
            [
                "label" => "Pedidos",
                "icon"  => "ShoppingOutlined",
                "children" => [
                    [
                        "label" => "Ordens de Serviço",
                        "path"  => "/os",
                        "icon"  => "ToolOutlined",
                    ]
                ]
            ]
        ];

        // Função recursiva para remover children vazios
        $formatMenu = function ($items) use (&$formatMenu) {
            return array_map(function ($item) use (&$formatMenu) {
                if (isset($item['children']) && empty($item['children'])) {
                    unset($item['children']); // remove array vazio
                } elseif (isset($item['children'])) {
                    $item['children'] = $formatMenu($item['children']);
                }
                return $item;
            }, $items);
        };

        $menu = $formatMenu($menu);

        return $this->response->setJSON($menu);
    }
}
