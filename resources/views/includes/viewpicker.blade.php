@if($productsView == 'grid')
    <span class="viewpicker"><i class="fas fa-list"></i></span>
    <a href="{{ route('setview', 'list') }}" class="viewpicker p-md-0 p-2"><i class="fas fa-list"></i></a>
@else
    <a href="{{ route('setview', 'grid') }}" class="viewpicker p-md-0 p-2"><i class="fas fa-th"></i></a>
    <span class="viewpicker"><i class="fas fa-th"></i></span>
@endif
