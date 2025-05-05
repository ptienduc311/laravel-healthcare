<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\PostCategory;

class PostCategoryComposer
{
    public function compose(View $view): void
    {
        $menu_post_categories = PostCategory::where('status', 1)->get();

        $view->with('menu_post_categories', $menu_post_categories);
    }
}
