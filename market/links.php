<?php


use Dacota\Controller\Controller as path;

$links = [
        path::link('/general', 'generalPage'),
        path::link('/products', 'productList'),
        path::link('/product/{id:int}', 'product'),
        path::link('/product', 'product'),
        path::link('', 'generalPage'),
];