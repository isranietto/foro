<?php

namespace Foro\Http\Composers;


use Foro\Category;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class PostSidebarComposer
{
    protected $listPostRoute = ['post.index', 'posts.completed', 'posts.pending'];

    public function compose(View $view)
    {
        $view->categoryItems = $this->getCategoryItems();
        $view->filters = trans('menu.filters');
    }

    protected function getCategoryItems()
    {
        $routeName = Route::getCurrentRoute()->getName();

        if (!in_array($routeName, $this->listPostRoute)) {
            $routeName = 'post.index';
        }

        return  Category::query()
            ->orderBy('name')
            ->get()
            ->map(function ($category) use ($routeName){
            return [
                'title' => $category->name,
                'full_url' => route($routeName, $category)
            ];
        })->toArray();
    }
}