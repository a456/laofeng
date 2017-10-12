@extends('admin.public.parent')

@section('content')
        
            <!-- Deafult Table -->
                <div class="block-area" id="defaultStyle">
                    <h3 class="block-title">Default Style</h3>
                    @if (session('msg'))
                        <script>
                            alert("{{ session('msg') }}");
                        </script>
                    @endif
                    <form name='myform' action="" method='post' style='display:none'>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                    <form action="{{ url('users') }}">
                        <div class='medio-body'>
                            姓名：<input type="text" class='form-control input-sm' name='name'>
                        </div>
                        <div class='medio-body'>
                            性别：<select class='form-control m-b-10' name="sex" id="">
                                <option value=''>--请选择--</option>
                                <option value="1">男</option>
                                <option value="2">女</option>
                            </select>
                        </div>
                        <input type="submit" class='btn btn-sm' value='搜索'>

                    </form>
                    <br>
                    <table class="table tile">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>age</th>
                                <th>sex</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->age }}</td>
                                    <td>{{ ($user->sex == 1)?'男':'女' }}</td>
                                    <td>
                                        <a href="{{ url('users/'.$user->id.'/edit') }}" class='btn btn-sm'>修改</a>
                                        <a href="javascript:doDel({{ $user->id }})" class='btn btn-sm'>删除</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- ['name'=>'huang'] -->
                    {!! $users->appends($where)->render() !!}
                </div>    
@endsection

