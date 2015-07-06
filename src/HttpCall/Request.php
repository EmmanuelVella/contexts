<?php

namespace Sanpi\Behatch\HttpCall;

use Behat\Mink\Mink;

class Request
{
    private $mink;
    private $request;

    public function __construct(Mink $mink)
    {
        $this->mink = $mink;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->getClient(), $name], $arguments);
    }

    private function getClient()
    {
        if (null === $this->request) {
            if ($this->mink->getDefaultSessionName() === 'symfony2') {
                $this->request = new Request\Goutte($this->mink);
            } else {
                $this->request = new Request\BrowserKit($this->mink);
            }
        }

        return $this->request;
    }
}
