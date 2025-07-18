<?php

namespace RectorLaravel\Tests\Rector\Class_\UseForwardCallsTraitRector\Fixture;

class DontDuplicateTrait
{
    use \Illuminate\Support\Traits\ForwardCalls;
    private SomeCall $foo;

    public function __call($method, $args)
    {
        return call_user_func_array([$this->foo, $method], $args);
    }
}

?>
-----
<?php

namespace RectorLaravel\Tests\Rector\Class_\UseForwardCallsTraitRector\Fixture;

class DontDuplicateTrait
{
    use \Illuminate\Support\Traits\ForwardCalls;
    private SomeCall $foo;

    public function __call($method, $args)
    {
        return $this->forwardCallTo($this->foo, $method, $args);
    }
}

?>
