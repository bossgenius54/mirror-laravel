<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">

        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <b>
                    <img src="/assets/images/logo-icon.png" alt="homepage" class="dark-logo" style="height: 40px;     width: 40px;" />
                </b>
                <span>
                    <img src="/assets/images/logo-text.png" alt="homepage" class="dark-logo" style="height: 40px;     width: 128px;" />
                </span>
            </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto mt-md-0">
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item">

                    @can('create', App\Model\Order::class)

                        @php
                            $ar_type = App\Model\SysOrderType::pluck('name', 'id')->toArray();
                        @endphp

                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info dropdown-toggle"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    style="font-size: 15px;">

                                    <i class="mdi mdi-cart-plus"></i>
                                    Новый заказ
                            </button>
                            <div class="dropdown-menu">
                                @foreach ($ar_type as $k=>$v)
                                    <a href="{{ action('Order\CreateOrderController@getCreate', $k) }}"
                                        class="dropdown-item " >
                                        Добавить "{{ $v }}"
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endcan

                    @can('create', App\Model\View\Individ::class)
                        <a href="{{ action('Lib\IndividController@getCreate') }}" class="nav-link text-muted waves-effect waves-dark">
                            <i class="mdi mdi-account-box-outline"></i> Новый клиент
                        </a>
                    @endcan
                </li>
            </ul>
            <ul class="navbar-nav my-lg-0">

                <li class="nav-item dropdown">
                    <a  class="nav-link dropdown-toggle text-muted waves-effect waves-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            href="" >
                        <img src="{{ Auth::user()->photo ? Auth::user()->photo : '/assets/images/users/user-default-1.svg' }}" alt="user" class="profile-pic" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img">
                                        <img src="{{ Auth::user()->photo ? Auth::user()->photo : '/assets/images/users/user-default-1.svg' }}" alt="user">
                                    </div>
                                    <div class="u-text">
                                        <h4 style="max-width: 140px;">{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ action('ProfileController@getIndex') }}">
                                    <i class="mdi mdi-settings"></i> Профиль
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('LoginController@getLogout') }}">
                                    <i class="fa fa-power-off"></i> Выйти
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
