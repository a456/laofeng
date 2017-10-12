@extends('admin.public.parent')
@section('content')
<div class="block-area" id="upload">
	<form action="{{ url('uploads') }}" method='post' enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="fileupload fileupload-new" data-provides="fileupload">
	        <span class="btn btn-file btn-sm btn-alt">
	            <span class="fileupload-new">Select file</span>
	            <span class="fileupload-exists">Change</span>
	            <input type="file" name='mypic' />
	        </span>
	        <span class="fileupload-preview"></span>
	        <a href="#" class="close close-pic fileupload-exists" data-dismiss="fileupload">
	            <i class="fa fa-times"></i>
	        </a>
	    </div>
	   	<input type="submit" class='btn' value='上传'>
    </form>
</div>
@endsection
