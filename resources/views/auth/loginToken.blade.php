@extends('backend.layouts.blank')

@section('content')
    <form id="frm" class="pad-hor" method="POST" role="form" action="{{ route('login.submit.token') }}">
        @csrf
        <input type="hidden" name="token" id="token">
        <input type="hidden" name="src" id="src">
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        var message = JSON.stringify({
            action: 'loginByToken'
        });
        window.parent.postMessage(message, '*');
        window.addEventListener('message', function(e) {
            var data = JSON.parse(e.data);
            if(data.action == 'loginByToken'){
                $('#token').val(data.token);
                $('#src').val(data.src);
                $("#frm").submit();
            }
        });
    </script>
@endsection
