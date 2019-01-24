<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li>
                    <a class="waves-effect waves-dark" href="/">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">
                            Главная
                        </span>
                    </a>
                </li>
                @can('list', App\Model\View\IncomeFromCompany::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\IncomeFromCompanyController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Оприходование
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Motion::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\MotionController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Перемещение
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Position::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\PositionController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Позиции/Товары
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Product::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\ProductController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Ассортимент товаров
                            </span>
                        </a>
                    </li>
                @endcan
                <li class="nav-small-cap">Справочники</li>
                @can('list', App\Model\View\Individ::class)
                    <li>
                        <a class="" href="{{ action('Lib\IndividController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Физ. лица
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\Doctor::class)
                    <li>
                        <a class="" href="{{ action('Lib\DoctorController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Доктора
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\Manager::class)
                    <li>
                        <a class="" href="{{ action('Lib\ManagerController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Менеджеры
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\CompanyService::class)
                    <li>
                        <a class="" href="{{ action('Lib\CompanyServiceController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Услуги
                            </span>
                        </a>
                    </li>
                @endcan
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
                
                @can('list', App\Model\View\Individ::class)
                    <li class="nav-small-cap">Системные</li>
                    <li>
                        <a class="" href="{{ action('System\AuthLogController@getIndex') }}">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">
                                Логи авторизации
                            </span>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>
    </div>
</aside>