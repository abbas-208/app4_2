<div class="d-flex flex-column flex-shrink-0 p-3" id="admin-sidebar">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <span class="fs-4" id="sidebar-logo">TaGET</span>
    </a>
    <hr>
        <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->route()->getName() == 'dashboard' ? 'active' : '' }}" aria-current="page">
                <i class="fa fa-tachometer"></i> Dashboard
            </a>
        </li>
        @if(Auth::user()->isServiceManager == 1)
            <li class="nav-item">
                <a href="{{ route('masterTrading.index') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'master') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Master Trading
                </a>
            </li>
        @endif
        <li class="nav-item has-submenu">
            <a class="nav-link" href="#" id="submenu-closed"> <i class="fas fa-clipboard-list"></i> Trading &#128899 </a>
            <ul class="submenu collapse">
                @if(Auth::user()->trading_position == 1)
                    <li><a href="{{ route('buyerTradingHistory') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'TradingHistory') ? 'active' : '' }}">
                        Trading History </a>
                    </li>
                    <li><a href="{{ route('buyerMarket') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'Market') ? 'active' : '' }}">
                        Current Market </a>
                    </li>
                @elseif(Auth::user()->trading_position == 2)
                    <li><a href="{{ route('sellerTradingHistory') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'TradingHistory') ? 'active' : '' }}">
                        Trading History </a>
                    </li>
                    <li><a href="{{ route('sellerMarket') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'Market') ? 'active' : '' }}">
                        Current Market </a>
                    </li>
                @else
                    <li><a href="{{ route('bothTradingHistory') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'TradingHistory') ? 'active' : '' }}">
                        Trading History </a>
                    </li>
                    <li><a href="{{ route('bothMarket') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'Market') ? 'active' : '' }}">
                        Current Market </a>
                    </li>
                @endif
            </ul>
        </li>
        @if(Auth::user()->isServiceManager == 1)
            <li class="nav-item">
                <a href="{{ route('manageUser') }}" class="nav-link  {{ str_contains(request()->route()->getName(), 'User') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i> User Management
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a href="{{ route('profile.index') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'profile') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Profile
            </a>
        </li>
        </ul>

        <div class="mb-2 admin-info">
            <span class="admin-info-title">Zone: </span>
            <span class="admin-info-value"> {{ Auth::user()->zone->name }}</span>
        </div>
        <div class="mb-2 admin-info">
            <span class="admin-info-title">Trading Position: </span><br>
            <span class="admin-info-value">
                @if (Auth::user()->isServiceManager)
                    - Service Manager <br> - 
                @endif
                {{ Auth::user()->trading_position == 1 ? 'Buyer' : (Auth::user()->trading_position == 2 ? 'Seller' : 'Both Buyer & Seller') }}
            </span>
        </div>
        <div class="admin-info">
            <span class="admin-info-title">Balance: </span>
            <span class="admin-info-value"> {{ Auth::user()->balance }}$ </span>
        </div>

    <hr>
</div>
