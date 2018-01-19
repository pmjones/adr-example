<?php
namespace Pmjones\Adr\Web\Blog;

use Pmjones\Adr\Web\Responder;
use Aura\View\View as Template;

class BlogResponder extends Responder
{
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    protected function registerTemplates() : void
    {
        $registry = $this->template->getViewRegistry();
        $path = dirname(dirname(dirname(__DIR__))) . '/resources/templates/blog';
        $files = glob("{$path}/*.php");
        foreach ($files as $file) {
            $name = substr(basename($file), 0, -4);
            $registry->set($name, $file);
        }
    }

    protected function renderTemplate($name) : void
    {
        $this->registerTemplates();
        $this->template->setView($name);
        $this->template->addData($this->payload->getResult());
        $this->response->getBody()->write($this->template->__invoke());
    }
}
