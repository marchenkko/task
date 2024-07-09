<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @param $taskId
     * @return JsonResponse
     */
    public function store(Request $request, $taskId): JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $task = Task::findOrFail($taskId);

        $comment = new Comment([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        $task->comments()->save($comment);

        return response()->json($comment, 201);
    }

    /**
     * @param $taskId
     * @return JsonResponse
     */
    public function index($taskId): JsonResponse
    {
        $task = Task::findOrFail($taskId);
        $comments = $task->comments;

        return response()->json($comments);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment removed'], 200);
    }
}
