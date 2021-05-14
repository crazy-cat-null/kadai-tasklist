<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests\StoreBlogPost;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
    
    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // task作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    // postでtask/にアクセスされた場合の「新規登録処理」
    public function store(StoreBlogPost $request)
    {   $validated = $request->validated();
    
        // 認証済みユーザ（閲覧者）タスク稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'content' => $request->content,
             'status' => $request->status
            
        ]);


        // トップページへリダイレクトさせる
        return redirect('/');

    }

    // getでtask/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でtaskを検索して取得
        $task = Task::findOrFail($id);
        

        // task詳細ビューでそれを表示
        if (\Auth::id() === $task->user_id){
            return view('tasks.show', [
            'task' => $task,
        ]);
        }
        else{
            return redirect('/');
        }
    }

     public function edit($id)
    {
        // idの値でtaskを検索して取得
        $task = Task::findOrFail($id);
        
        // task編集ビューでそれを表示
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
            'task' => $task,
        ]);
        }
        else{
            return redirect('/');
        }
    }

       public function update(StoreBlogPost $request, $id)
    {   
        $validated = $request->validated();
        
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスクを更新
        
        if (\Auth::id() === $task->user_id){
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }
    
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がその侑の所有者である場合は、侑を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }
    
}
