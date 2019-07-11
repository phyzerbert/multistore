@php
    $pagesize = session('pagesize');
    if(!$pagesize){$pagesize = 15;}
@endphp     
<form class="form-inline ml-3 float-left mb-2" action="{{route('set_pagesize')}}" method="post" id="pagesize_form">
    @csrf
    <label for="pagesize" class="control-label">{{__('page.show')}} :</label>
    <select class="form-control form-control-sm mx-2" name="pagesize" id="pagesize">
        <option value="" @if($pagesize == '') selected @endif>15</option>
        <option value="25" @if($pagesize == '25') selected @endif>25</option>
        <option value="50" @if($pagesize == '50') selected @endif>50</option>
        <option value="100" @if($pagesize == '100') selected @endif>100</option>
    </select>
</form>