<?php


class ProductForm
{
    public $fields = [
            'name',
            'price',
            'category',
            'brand',
    ];
    public $data = [];
    private $post = [];
    public $messages = [];
    private $instance;

    public function __construct($post, $instance)
    {
        $this->post = $post;
        $this->instance = $instance;
    }

    public function valid()
    {
        $diff = array_diff($this->fields, array_keys($this->post));
        if ($diff) {
            $this->messages[] = ['danger' => "Отсутствует поле: ".implode(',', $diff)];
        }
        if ($this->messages) {
            return false;
        }
        return true;
    }

    public function handling()
    {
        if (!$this->valid()) {
            return false;
        }
        $this->data = array_intersect_key($this->post, array_flip($this->fields));
        $this->instance->setName($this->data['name']);
        $this->instance->setPrice($this->data['price']);
        if (isset($this->data['brand'])) {
            $this->instance->setBrand(Brand::objects()->find($this->data['brand']));
        }
        if (isset($this->data['category'])) {
            $this->instance->setCategory(Category::objects()->find($this->data['category']));
        }

        return true;
    }


    public function save($commit = true)
    {
        if ($this->messages) {
            return false;
        }
        return $this->instance->save($commit);
    }
}