<?php

namespace RectorLaravel\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector\Fixture;

class Config
{
    public function actionGet()
    {
        $value = config('value');
    }

    public function actionSet($value)
    {
        config(['value' => $value]);
    }
}

?>
-----
<?php

namespace RectorLaravel\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector\Fixture;

class Config
{
    public function __construct(private readonly \Illuminate\Contracts\Config\Repository $configRepository)
    {
    }
    public function actionGet()
    {
        $value = $this->configRepository->get('value');
    }

    public function actionSet($value)
    {
        $this->configRepository->set(['value' => $value]);
    }
}

?>
