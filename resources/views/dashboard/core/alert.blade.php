<div class="container-fluid">
    @if(session('fail'))
        <div class="alert alert-danger">
             {{ session('fail') }}
        </div>   
    @endif

    @if(session('success'))
        <div class="alert alert-info">
            {{ session('success') }}
        </div>   
    @endif
</div>