<?php
abstract class Controller 
{
    protected Request $request;
    protected PageView $view;

    public function __construct(Request $request) 
    {
        $this->request = $request;
        $this->view = new PageView();
    }

    abstract public function execute(): void;
}
