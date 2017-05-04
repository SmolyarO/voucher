<form class="form-horizontal edit-group" method="post" action="{{ $action }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-default">{{ $text }}</button>
</form>
