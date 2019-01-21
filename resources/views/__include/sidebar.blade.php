<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li>
                    <a class="waves-effect waves-dark" href="/">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">
                            Cards
                        </span>
                    </a>
                </li>
                <li> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">
                            Справочники 
                            <span class="label label-rouded label-themecolor pull-right">4</span>
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/">Minimal </a></li>
                    </ul>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="ui-cards.html">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">
                            Cards
                        </span>
                    </a>
                </li>
                <li class="nav-small-cap">Справочники</li>
                @can('list', App\Model\Branch::class)
                    <li>
                        <a class="" href="{{ action('Lib\BranchController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Филиалы
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\Director::class)
                    <li>
                        <a class="" href="{{ action('Lib\DirectorController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Директора
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Company::class)
                    <li>
                        <a class="" href="{{ action('Lib\CompanyController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Компании
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\LibProductCat::class)
                    <li>
                        <a class="" href="{{ action('Lib\LibProductCatController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Категории товаров
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\LibProductType::class)
                    <li>
                        <a class="" href="{{ action('Lib\LibProductTypeController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Виды опций товаров
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\LibProductOption::class)
                    <li>
                        <a class="" href="{{ action('Lib\LibProductOptionController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Опции товаров
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\LibCompanyCat::class)
                    <li>
                        <a class="" href="{{ action('Lib\LibCompanyCatController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Формы собственности
                            </span>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>
    </div>
</aside>