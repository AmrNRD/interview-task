<?php

namespace App\Module\Dashboard\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

use App\Module\General\Repositories\Contracts\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * View Path.
     *
     * @var string
     */
    protected $viewPath = 'dashboard';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'Dashboard';

    /**
     * Module Alias.
     *
     * @var string
     */
    protected $moduleAlias = 'Dashboards';


    /**
     * Get All Dashboard.
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
        return view("{$this->moduleAlias}::{$this->viewPath}.index",[
            'data' => []
        ]);
    }
}
