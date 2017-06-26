@extends('layouts.admin')

@section('head')

@stop

@section('content')


@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif
<div class="row">
    <div class="col-md-6">
      <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Part 1</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="{{route('admin.mcq-emq')}}"> MCQs, EMQs </a></td>
            </tr>
            <tr>
              <td><a href="{{route('admin.essay-questions')}}"> Essay questions </a></td>
            </tr>
          </tbody>
        </table>
    </div>
    <div class="col-md-6">
      <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Part 2</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="{{route('admin.morphology')}}"> Morphology </a></td>
            </tr>
            <tr>
              <td><a href="{{route('admin.quality-assurance')}}"> Quality assurance </a></td>
            </tr>
            <tr>
              <td><a href="{{route('admin.transfusion')}}"> Transfusion </a></td>
            </tr>
          </tbody>
        </table>
    </div>
  
    {!! Form::open(['url' => route('admin.recent-updates'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
      <div class="form-group">
        <label for="email">Recent Updates:</label>
        <textarea name="update" rows="5" class="form-control"></textarea>
        
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    {!! Form::close() !!}
    <br>
    <h4>Recent updates listing</h4>
    <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Sno.</th>
        <th>Update</th>
        <th>Created</th>
        <th>Action</th>
      </tr>
    </thead>
      <tbody>
        @if(count($results))
          <?php $i = 1; ?>
          @foreach($results as $row)           
            <tr>
              <td>{{$i}}</td>
              <td><?php echo base64_decode($row->updates); ?></td>
              <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
              <td><a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-updates', ['id' => $row->id ])}}">Delete</a></td>
            </tr>
            <?php $i++;?>
          @endforeach
        @endif
      </tbody>
  </table>
  <div class="pagination"> {{ $results->links() }} </div>

  </div>    

@stop