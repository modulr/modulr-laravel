<?php

namespace App\Http\Controllers\Comments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments\ProjectComment;

class ProjectCommentsController extends Controller
{
    public function __construct()
    {
        $this->relationships = ['user'];
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required|string'
        ]);

        $comment = ProjectComment::create([
            'project_id' => $id,
            'comment' => $request->comment,
            'user_id' => Auth::id()
        ])->load($this->relationships);
        
        return $comment;
    }
}