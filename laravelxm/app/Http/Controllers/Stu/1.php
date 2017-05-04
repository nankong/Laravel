<?php
	namespace App\Http\Controllers\Stu;

	use Illuminate\Http\Request;
	use App\Http\Controller\Controller;
	use DB;

	class StuController extends Controller
	{
		public function index()
		{
			$list = DB::table('user')->get();
		}

		return view('Stu.index',['list' => $list]);
	}

	public function store(Request $request)
	{
		$data = $request->insertGetId($data);

		if($row>0){
			return redirect('/stu')->with('info','添加成功');
		}else{
			return redirect('/stu/create')->with('info','添加失败！');
		}
	}

	public function show($id)
	{

	}

	public function edit($id)
	{
		$row = DB::table('user')->where('uid','=',$id)->first();

		return view('Stu.edit',['ob' =>$row]);
	}

	public function update(Request $request, $id)
	{
		$data = $request->only('name','age','sex');

		$row = DB::table('/stu')->where('uid',$id)->update($data);

		if($row>0){
			return redirect('/stu')->with('info','修改成功');
		}else{
			return redirect("stu/{$id}/edit")->with('info','修改失败！');
		}
	}