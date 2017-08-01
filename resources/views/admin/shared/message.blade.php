@foreach (['danger', 'warning', 'success', 'info', 'status'] as $msg)
  @if(session()->has($msg))
      <div class="alert alert-{{ $msg }}">
        {{ session()->get($msg) }}
      </div>
  @endif
@endforeach