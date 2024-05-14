@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                
                    
                    <form  action="{{route('send_emails')}}"   method="post">

                    @csrf
                    <div class="form_group">
                        <label for="title">Title</label>
                        <input class="form-control "
                               type="text" 
                               name="title"
                               placeholder="Title"
                               value="{{old('title')}}">
                               @error('title')<span class="text-danger">{{$message}}</span>@enderror
                                   
                              
                    </div>  
                    <div class="form_group">
                        <label for="body">body</label>
                        <textarea class="form-control"
                               type="text" 
                               name="body"
                               
                               value="{{old('body')}}">      
                        </textarea>
                        @error('body')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="form_group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>       
                       
                                          
                    </form>

                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
