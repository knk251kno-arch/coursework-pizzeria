<?php
class PageView extends View 
{
    public function renderPage(string $template, array $data = [], string $title = 'Піцерія'): void 
    {
        $content = $this->render($template, $data);
        $layoutData = [
            'title' => $title,
            'content' => $content
        ];
        echo $this->render('layout/header', $layoutData);
        echo $content;
        echo $this->render('layout/footer', $layoutData);
    }
}
