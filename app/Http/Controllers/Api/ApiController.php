<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AppResponseTrait;

class ApiController extends Controller{

    use AppResponseTrait;

    /**
     * @var int
     * Pagination default limit
     */
    protected $limit = 10;

    protected  $sort = ['field' => 'id','sort' => 'desc'];

    protected  $search = ['searchQuery' => ''];
}
