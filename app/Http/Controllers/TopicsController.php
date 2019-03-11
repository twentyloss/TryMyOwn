<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request,Topic $topic)
	{

		$topics = $topic->withOrder($request->order)->paginate(15);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories=Category::all();

		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
		$topic->fill($request->all());
		$topic->user_id=Auth::id();
		$topic->save();
		return redirect()->route('topics.show', $topic->id)->with('success', '创建成功~！😊.');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories=Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('success', '更新成功！😀');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功啦~！');
	}

	public function uploadImage(Request $request,ImageUploadHandler $handler,Topic $topic){
       $data=['success'=>false,
           'msg'=>'上传失败',
           'file_path'=>' '];
       if($file=$request->upload_file){
        $result=$handler->save($file,'topics_upload',\Auth::id(),751);
        if($result){
            $data=['success'=>true,
                'msg'=>'图片上传成功！',
                'file_path'=>$result['path']];
        }

        }
       return $data;

    }
}