@extends('layout')

@section('content')
    <div class="content">
        <div class="container">
            <form action="/categories/store" method="get" class="mt-5">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" name="name" placeholder="Shoes"/>
                </div>
                <div class="form-group">
                    <label for="parent_id">Parent category</label>
                    <input class="form-control" id="parent_id" name="parent_id" placeholder="0"/>
                </div>
                <div class="form-group">
                    <label for="external_id">External id</label>
                    <input class="form-control" id="external_id" name="external_id" placeholder="123"/>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" />
                </div>
            </form>
        </div>
    </div>
@endsection
