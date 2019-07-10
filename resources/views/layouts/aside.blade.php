@php
    $page = config('site.page');
    $role = Auth::user()->role->slug;
@endphp
<div class="br-logo"><a href="{{route('home')}}"><span>{{config('app.name')}}</span></a></div>
<div class="br-sideleft overflow-y-auto">
    <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
    <div class="br-sideleft-menu">
        <a href="{{route('home')}}" class="br-menu-link @if($page == 'home') active show-sub @endif">
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
            $report_items = [
                'overview_chart', 
                'company_chart', 
                'store_chart', 
                'product_quantity_alert', 
                'product_expiry_alert', 
                'products_report', 
                'categories_report', 
                'sales_report', 
                'purchases_report', 
                'daily_sales', 
                'monthly_sales', 
                'payment_report', 
                'customer_report', 
                'suppliers_report', 
                'users_report',
            ];
        @endphp

        <a href="#" class="br-menu-link @if($page == in_array($page, $report_items)) active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon fa fa-file-text-o tx-24"></i>
                <span class="menu-item-label">Reports</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{route('report.overview_chart')}}" class="nav-link @if($page == 'overview_chart') active @endif">Overview Chart</a></li>
            <li class="nav-item"><a href="{{route('report.company_chart')}}" class="nav-link @if($page == 'company_chart') active @endif">Company Chart</a></li>
            {{-- <li class="nav-item"><a href="#" class="nav-link @if($page == 'store_chart') active @endif">Store Chart</a></li> --}}
            <li class="nav-item"><a href="{{route('report.product_quantity_alert')}}" class="nav-link @if($page == 'product_quantity_alert') active @endif">Product Quantity Alert</a></li>
            {{-- <li class="nav-item"><a href="#" class="nav-link @if($page == 'product_expiry_alert') active @endif">Product Expiry Alert</a></li> --}}
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'products_report') active @endif">Product Report</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'categories_report') active @endif">Category Report</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'sales_report') active @endif">Sales Report</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'purchases_report') active @endif">Purchase Report</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'daily_sales') active @endif">Daily Sales</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'monthly_sales') active @endif">Monthly Sales</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'payment_report') active @endif">Payment Report</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'customer_report') active @endif">Customer Report</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'suppliers_report') active @endif">Suppliers Report</a></li>
            <li class="nav-item"><a href="#" class="nav-link @if($page == 'users_report') active @endif">Users Report</a></li>
        </ul>

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
            @if($role == 'admin')
                <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link @if($page == 'user') active @endif">Users</a></li>
            @endif
            <li class="nav-item"><a href="{{route('customer.index')}}" class="nav-link @if($page == 'customer') active @endif">Customers</a></li>
            <li class="nav-item"><a href="{{route('supplier.index')}}" class="nav-link @if($page == 'supplier') active @endif">Suppliers</a></li>
        </ul>
        @if($role == 'admin')
        {{-- Setting --}}
        @php
            $setting_items = ['category', 'store', 'company'];
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
            <li class="nav-item"><a href="{{route('company.index')}}" class="nav-link @if($page == 'company') active @endif">Company</a></li>
            <li class="nav-item"><a href="{{route('store.index')}}" class="nav-link @if($page == 'store') active @endif">Store</a></li>
        </ul>
        @endif
    </div>

    <br>
</div>