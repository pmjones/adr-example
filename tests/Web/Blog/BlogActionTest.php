<?php
namespace Pmjones\Adr\Web\Blog;

use Aura\Html\HelperLocatorFactory;
use Aura\View\ViewFactory;
use Pmjones\Adr\DataSource\Blog\BlogMapper;
use Pmjones\Adr\Domain\Blog\BlogFilter;
use Pmjones\Adr\Domain\Blog\BlogService;
use Pmjones\Adr\SqliteFixture;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

abstract class BlogActionTest extends \PHPUnit\Framework\TestCase
{
    protected $action;

    protected function setup()
    {
        $test = strrchr(get_class($this), '\\');
        $name = substr($test, 5, -10); // BlogAddActionTest => Add

        $pdo = SqliteFixture::setup();

        $domain = new BlogService(
            new BlogMapper($pdo),
            new BlogFilter()
        );

        $helperLocator = (new HelperLocatorFactory())->newInstance();
        $view = (new ViewFactory())->newInstance($helperLocator);

        $class = "Pmjones\Adr\Web\Blog\\{$name}\Blog{$name}Responder";
        $responder = new $class($view);

        $class = "Pmjones\Adr\Web\Blog\\{$name}\Blog{$name}Action";
        $this->action = new $class($domain, $responder);
    }

    protected function newRequest(array $attributes = [], array $query = [], array $post = [])
    {
        $request = ServerRequestFactory::fromGlobals();
        foreach ($attributes as $key => $val) {
            $request = $request->withAttribute($key, $val);
        }
        return $request->withQueryParams($query)->withParsedBody($post);
    }
}
