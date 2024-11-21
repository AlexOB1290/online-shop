<?php

//print_r($_SERVER);

    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    if ($uri === '/registrate') {
        if ($method === 'GET') {
            require_once './get_registration.php';
        } elseif ($method === 'POST') {
            require_once './handle_registration.php';
        } else {
            echo "$method не поддерживается адресом $uri";
        }
    } elseif ($uri === '/login') {
        if ($method === 'GET') {
            require_once './get_login.php';
        } elseif ($method === 'POST') {
            require_once './handle_login.php';
        } else {
            echo "$method не поддерживается адресом $uri";
        }
    } elseif ($uri === '/catalog') {
        if ($method === 'GET') {
            require_once './catalog.php';
        } else {
            echo "$method не поддерживается адресом $uri";
        }
    } elseif ($uri === '/add-product') {
        if ($method === 'GET') {
            require_once './get_add_product.php';
        } elseif ($method === 'POST') {
            require_once './handle_add_product.php';
        } else {
            echo "$method не поддерживается адресом $uri";
        }
    } else {
        require_once './404.html';
    }
