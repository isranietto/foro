<?php

namespace Foro\Http\Controllers;

use Foro\Post;
use Foro\Category;
use Illuminate\Http\Request;

class ListPostController extends Controller
{

    public function __invoke(Category $category = null, Request $request)
    {

        list($orderColumn, $orderDirection) = $this->getLIstOrder($request->get('orden'));

        $posts = Post::query()
            ->with(['user', 'category'])
            ->category($category)
            ->orderBy('created_at', 'DESC')
            ->scopes($this->getRouteScope($request))
            ->myorderby($orderColumn, $orderDirection)
            ->paginate();

        return view('post.index', compact('posts','category'));
    }

    public function getRouteScope(Request $request)
    {
        $scopes = [
            'post.mine' => ['byUser' => [$request->user()]] ,
            'post.pending' => ['pending'],
            'post.completed' => ['completed'],
        ];

        $name = $request->route()->getName();

        return isset ($scopes[$name]) ? $scopes[$name]: [];
    }

    protected function getLIstOrder($order)
    {
        $orders = [
            'recientes' => ['created_at', 'desc'],
            'antiguos' => ['created_at', 'asc']
        ];

        return $orders[$order] ?? ['created_at', 'desc'];

        /*if (isset($orders[$order])) {
            return $orders[$order];
        }
        return ['created_at', 'desc'];*/
    }
}
