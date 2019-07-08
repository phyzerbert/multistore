@php
    $page = config('site.page');
@endphp
<div class="br-logo"><a href="{{route('home')}}"><span>{{config('app.name')}}</span></a></div>
<div class="br-sideleft overflow-y-auto">
    <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
    <div class="br-sideleft-menu">
        <a href="#" class="br-menu-link">
            <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
            </div>
        </a>

        {{-- Purchase --}}
        @php
            $purchase_items = ['purchase', 'purchase_list', 'purchase_create'];
        @endphp

        <a href="#" class="br-menu-link @if($page == in_array($page, $purchase_items)) active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-log-in tx-24"></i>
                <span class="menu-item-label">Purchases</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{route('purchase.index')}}" class="nav-link @if($page == 'purchase_list') active @endif">Purchases List</a></li>
            <li class="nav-item"><a href="{{route('purchase.create')}}" class="nav-link @if($page == 'purchase_create') active @endif">Add Purchase</a></li>
        </ul>

        {{-- Sale --}}
        @php
            $sale_items = ['sale', 'sale_list', 'sale_create'];
        @endphp

        <a href="#" class="br-menu-link @if($page == in_array($page, $sale_items)) active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-log-out tx-24"></i>
                <span class="menu-item-label">Sales</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{route('sale.index')}}" class="nav-link @if($page == 'sale_list') active @endif">Sales List</a></li>
            <li class="nav-item"><a href="{{route('sale.create')}}" class="nav-link @if($page == 'sale_create') active @endif">Add Sale</a></li>
        </ul>

        <a href="{{route('product.index')}}" class="br-menu-link @if($page == 'product') active @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon fa fa-cube tx-22"></i>
                <span class="menu-item-label">Product</span>
            </div>
        </a>
        @php
            $people_items = ['user', 'customer', 'supplier'];
        @endphp
        <a href="#" class="br-menu-link @if($page == in_array($page, $people_items)) active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-person-stalker tx-24"></i>
                <span class="menu-item-label">People</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link @if($page == 'user') active @endif">Users</a></li>
            <li class="nav-item"><a href="{{route('customer.index')}}" class="nav-link @if($page == 'customer') active @endif">Customers</a></li>
            <li class="nav-item"><a href="{{route('supplier.index')}}" class="nav-link @if($page == 'supplier') active @endif">Suppliers</a></li>
        </ul>
        {{-- Setting --}}
        @php
            $setting_items = ['category', 'store'];
        @endphp
        <a href="#" class="br-menu-link @if($page == in_array($page, $setting_items)) active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
                <span class="menu-item-label">Setting</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{route('category.index')}}" class="nav-link @if($page == 'category') active @endif">Category</a></li>
            <li class="nav-item"><a href="{{route('store.index')}}" class="nav-link @if($page == 'store') active @endif">Store</a></li>
        </ul>

    </div>

    <br>
</div>