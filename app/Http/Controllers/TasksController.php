<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // task一覧を取得
        $tasks = Task::all();

        // task一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
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
    public function store(Request $request)
    {
        // taskを作成
        $task = new Task;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // getでtask/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でtaskを検索して取得
        $task = Task::findOrFail($id);

        // task詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

     public function edit($id)
    {
        // idの値でtaskを検索して取得
        $task = Task::findOrFail($id);

        // task編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

       public function update(Request $request, $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスクを更新
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスクを削除
        $task->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
