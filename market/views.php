<?php

require_once 'Dacota/View.php';
require_once 'models/User.php';
require_once 'models/Product.php';
require_once 'forms/ProductForm.php';

use Dacota\View\Validator;
use Dacota\View\View as view;

function generalPage()
{
    $products = count(Product::objects()->findAll());
    $context = [
            'title'  => "Главная",
            'count' => [
                    'products' => $products
            ]
    ];
    view::render($context, __DIR__."/templates/general.pug");
}


function productList()
{
    $messages = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['remove'])) {
            $product = Product::objects()->find(intval($_POST['remove']));
            $name = $product->getName();
            if ($product) {
                if ($product->remove()) {
                    $messages[] = ['success' => 'Удалено '.$name];
                } else {
                    $messages[] = ['danger' => 'Не удалось удалить '.$name];
                }
            }
        }
    }
    $products = array_map(fn($item) => $item->getArray(), Product::objects()->findAll());
    $context = [
            'messages' => $messages,
            'title'    => "Товары",
            'products' => $products
    ];

    view::render($context, __DIR__."/templates/productList.pug");
}


function product($id = false)
{
    $messages = [];
    $instance = $id ? Product::objects()->find($id) : new Product();
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'save') {
            $form = new ProductForm($_POST, $instance);
            $form->handling();
            $obj = $form->save();
            if ($obj) {
                $messages[] = ['success' => 'Сохранено'];
            } else {
                $messages = $form->messages;
            }
        }
        if ($_POST['action'] == 'remove') {
            header("Location: /products");
            die();
        }
    }
    $context = [
            'form'      => $id ? $instance->getArray() : [],
            'categoies' => array_map(fn($item) => $item->getArray(), Category::objects()->findAll()),
            'brands'    => array_map(fn($item) => $item->getArray(), Brand::objects()->findAll()),
            'messages'  => $messages,
            'title'     => ($id ? 'Редактировать' : 'Добавить').' товар'
    ];
    view::render($context, __DIR__."/templates/product.pug");
}

