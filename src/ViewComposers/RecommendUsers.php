<?php
namespace Zhiyi\Component\ZhiyiPlus\PlusComponentPc\ViewComposers;

use Illuminate\View\View;
use function Zhiyi\Component\ZhiyiPlus\PlusComponentPc\createRequest;

class RecommendUsers
{
    public function compose(View $view)
    {
        $params = [
            'limit' => 9
        ];
        $api = '/api/v2/user/latests';
        // $api = '/api/v2/user/find-by-tags';

        $users = createRequest('GET', $api, $params);

        $view->with('users', $users);
    }
}