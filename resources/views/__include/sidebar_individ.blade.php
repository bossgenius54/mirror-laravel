<aside class="left-sidebar">
    <div class="scroll-sidebar">
        @include('__include.sidebar_profile')
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                
                <li>
                    <a class="waves-effect waves-dark" href="{{ action('Order\ListOrderController@getIndex') }}">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">
                            Заказы
                        </span>
                    </a>
                </li>
                
                <li>
                    <a class="waves-effect waves-dark" href="{{ action('Common\FormulaController@getIndex') }}">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">
                            Рецепты
                        </span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ action('ProfileController@getIndex') }}">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">
                            Профиль
                        </span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ action('LoginController@getLogout') }}">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">
                            Выйти
                        </span>
                    </a>
                </li>
            
            </ul>
        </nav>
    </div>
</aside>