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

        $posts = Post::orderBy('created_at', 'DESC')
            ->scopes($this->getListScopes($category ,$request))
            ->myorderby($orderColumn, $orderDirection)
            ->paginate();

        return view('post.index', compact('posts','category' ,'categoryItems'));
    }

    protected function getListScopes(Category $category, Request $request)
    {
        $scopes = [];

        if ($category->exists) {
            $scopes['category'] = [$category];
        }
        $routeName = $request->route()->getName();

        if ($routeName == 'post.pending') {
            $scopes[] = 'pending';
        }

        if ($routeName == 'post.completed') {
            $scopes[] = 'completed';
        }

        return $scopes;
    }

    protected function getLIstOrder($order)
    {
        if ($order == 'recientes') {
            return ['created_at', 'desc'];
        }
        if ($order == 'antiguos') {
            return ['created_at', 'asc'];
        }
        return ['created_at', 'desc'];
    }
}
