@if ($errors->any())
    <div class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>
            <i class="icon fa fa-ban"></i>Error
        </h4>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>
            <i class="icon fa fa-check"></i>Success
        </h4>
        {{ session('success') }}
    </div>
@elseif(session('info'))
    <div class="alert alert-info alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>
            <i class="icon fa fa-info"></i>Info
        </h4>
        {{ session('info') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>
            <i class="icon fa fa-ban"></i>Error
        </h4>
        {{ session('error') }}
    </div>
@elseif(session('warning'))
    <div class="alert alert-warning alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>
            <i class="icon fa fa-warning"></i>Warning
        </h4>
        {{ session('warning') }}
    </div>
@endif
