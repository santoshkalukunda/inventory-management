@push('style')
<style>
    .active {
    background-color: #4CAF50;
    color: white;
}
</style>
@endpush

<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">

        <ul class="side-menu metismenu">

            <li class="mt-1">
                <a class="{{ (request()->is('home')) ? 'bg-info text-white' : '' }} " href="{{route('home')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">FEATURES</li>
            <li>
                <a href="{{route('bills.index')}}" class="{{ (request()->is('bills*')) ? 'bg-info text-white' : '' }} "><i class="sidebar-item-icon fa fa-file"></i>
                    <span class="nav-label">Sales Bills</span></a>
            </li>
            <li>
                <a href="{{route('sale-dues.index')}}" class="{{ (request()->is('sale-dues*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-redo"></i>
                    <span class="nav-label">Sales Bill Due Logs</span></a>
            </li>
            <li>
                <a href="{{route('sales.index')}}" class="{{ (request()->is('sales*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-money-check-alt"></i>
                    <span class="nav-label">Sales Product List</span></a>
            </li>
            <li>
                <a href="{{route('customers.index')}}" class="{{ (request()->is('customers*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-user-friends"></i>
                    <span class="nav-label">Customers</span></a>
            </li>
            <li>
                <a href="{{route('purchase-bills.index')}}" class="{{ (request()->is('purchase-bills*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-file-alt"></i>
                    <span class="nav-label">Purshase Bill</span></a>
            </li>
            <li>
                <a href="{{route('purchase-dues.index')}}"class="{{ (request()->is('purchase-dues*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-history"></i>
                    <span class="nav-label">Purshase Bill Due Logs</span></a>
            </li>
            <li>
                <a href="{{route('purchase.index')}}" class="{{ (request()->is('purchases*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-shopping-cart"></i>
                    <span class="nav-label">Purshase Product List</span></a>
            </li>
            <li>
                <a href="{{route('dealers.index')}}"  class="{{ (request()->is('dealers*')) ? 'bg-info text-white' : '' }}" ><i class="sidebar-item-icon fa fa-user"></i>
                    <span class="nav-label">Dealers</span></a>
            </li>
            <li>
                <a href="{{route('stores.index')}}"  class="{{ (request()->is('stores*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-warehouse"></i>
                    <span class="nav-label">Inventories</span></a>
            </li>
            <li>
                <a href="{{route('products.index')}}"  class="{{ (request()->is('products*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-file-alt"></i>
                    <span class="nav-label">Products</span></a>
            </li>
            <li>
                <a href="{{route('categories.index')}}"  class="{{ (request()->is('categories*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-code-branch"></i>
                    <span class="nav-label">Categories</span></a>
            </li>
            <li>
                <a href="{{route('brands.index')}}" class="{{ (request()->is('brands*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-copyright"></i>
                    <span class="nav-label">Brands</span></a>
            </li>
            <li>
                <a href="{{route('units.index')}}"  class="{{ (request()->is('units*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-balance-scale"></i>
                    <span class="nav-label">Units</span></a>
            </li>
            <li>
                <a href="{{route('companies.edit')}}"  class="{{ (request()->is('companies*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-building"></i>
                    <span class="nav-label">Company Profile</span></a>
            </li>
            <li>
                <a href="{{route('users.index')}}"  class="{{ (request()->is('users*')) ? 'bg-info text-white' : '' }}"><i class="sidebar-item-icon fa fa-users"></i>
                    <span class="nav-label">Users</span></a>
            </li>
            {{-- <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                    <span class="nav-label">Basic UI</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="colors.html">Colors</a>
                    </li>
                    <li>
                        <a href="colors.html">Colors</a>
                    </li>

                </ul>
            </li> --}}

        </ul>
    </div>
</nav>