<aside class="left-sidebar">
    <div class="scroll-sidebar">
        @include('__include.sidebar_profile')
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                @can('list', App\Model\Order::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Order\ListOrderController@getIndex') }}">
                            <i class="mdi mdi-cart-plus"></i>
                            <span class="hide-menu">
                                Заказы
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\ExternalDoctorSalary::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Common\ExternalDoctorSalaryController@getIndex') }}">
                            <i class="mdi mdi-account-plus"></i>
                            <span class="hide-menu">
                                Комис. внеш. врача
                            </span>
                        </a>
                    </li>
                @endcan
                
                <li class="nav-small-cap">Склад</li>
                @can('list', App\Model\View\IncomeFromCompany::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\IncomeFromCompanyController@getIndex') }}">
                            <i class="mdi mdi-format-horizontal-align-right"></i>
                            <span class="hide-menu">
                                Оприходование
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Outcome::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\OutcomeController@getIndex') }}">
                            <i class="mdi mdi-format-horizontal-align-left"></i>
                            <span class="hide-menu">
                                Отгрузки
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\IncomeReturned::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\IncomeReturnedController@getIndex') }}">
                            <i class="mdi mdi-backup-restore"></i>
                            <span class="hide-menu">
                                Возвраты
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Motion::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\MotionController@getIndex') }}">
                            <i class="mdi mdi-folder-move"></i>
                            <span class="hide-menu">
                                Перемещение
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Position::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\PositionController@getIndex') }}">
                            <i class="mdi mdi-book-open"></i>
                            <span class="hide-menu">
                                Позиции/Товары
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Product::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Stock\ProductController@getIndex') }}">
                            <i class="mdi mdi-barcode"></i>
                            <span class="hide-menu">
                                Ассортимент товаров
                            </span>
                        </a>
                    </li>
                @endcan
                
                <li class="nav-small-cap">Финансы</li>
                @can('list', App\Model\FinanceService::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Finance\FinanseServiceController@getIndex') }}">
                            <i class="fa fa-dollar"></i>
                            <span class="hide-menu">
                                По услугам
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\FinancePosition::class)
                    <li>
                        <a class="waves-effect waves-dark" href="{{ action('Finance\FinancePositionController@getIndex') }}">
                            <i class="fa fa-dollar"></i>
                            <span class="hide-menu">
                                По позициям
                            </span>
                        </a>
                    </li>
                @endcan
                <li class="nav-small-cap">Справочники</li>
                @can('list', App\Model\Company::class)
                    <li>
                        <a class="" href="{{ action('Lib\CompanyController@getIndex') }}">
                            <i class="mdi mdi-alphabetical"></i>
                            <span class="hide-menu">
                                Компании
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\Individ::class)
                    <li>
                        <a class="" href="{{ action('Lib\IndividController@getIndex') }}">
                            <i class="mdi mdi-account-box-outline"></i>
                            <span class="hide-menu">
                                Физ. лица
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\Doctor::class)
                    <li>
                        <a class="" href="{{ action('Lib\DoctorController@getIndex') }}">
                            <i class="mdi mdi-account"></i>
                            <span class="hide-menu">
                                Доктора
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\Manager::class)
                    <li>
                        <a class="" href="{{ action('Lib\ManagerController@getIndex') }}">
                            <i class="mdi mdi-account"></i>
                            <span class="hide-menu">
                                Менеджеры
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\StockManager::class)
                    <li>
                        <a class="" href="{{ action('Lib\StockManagerController@getIndex') }}">
                            <i class="mdi mdi-account"></i>
                            <span class="hide-menu">
                                Зав. складом
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\Accounter::class)
                    <li>
                        <a class="" href="{{ action('Lib\AccounterController@getIndex') }}">
                            <i class="mdi mdi-account"></i>
                            <span class="hide-menu">
                                Бухгалтера
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\ExternalDoctor::class)
                    <li>
                        <a class="" href="{{ action('Lib\ExternalDoctorController@getIndex') }}">
                            <i class="mdi mdi-account"></i>
                            <span class="hide-menu">
                                Внешние врачи
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\CompanyService::class)
                    <li>
                        <a class="" href="{{ action('Lib\CompanyServiceController@getIndex') }}">
                            <i class="mdi mdi-alert-octagram"></i>
                            <span class="hide-menu">
                                Услуги
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\Branch::class)
                    <li>
                        <a class="" href="{{ action('Lib\BranchController@getIndex') }}">
                            <i class="mdi mdi-archive"></i>
                            <span class="hide-menu">
                                Филиалы
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\View\Director::class)
                    <li>
                        <a class="" href="{{ action('Lib\DirectorController@getIndex') }}">
                            <i class="mdi mdi-account-box"></i>
                            <span class="hide-menu">
                                Директора
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\LibProductCat::class)
                    <li>
                        <a class="" href="{{ action('Lib\LibProductCatController@getIndex') }}">
                            <i class="mdi mdi-alert-octagram"></i>
                            <span class="hide-menu">
                                Категории товаров
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\LibProductType::class)
                    <li>
                        <a class="" href="{{ action('Lib\LibProductTypeController@getIndex') }}">
                            <i class="mdi mdi-alert-octagram"></i>
                            <span class="hide-menu">
                                Виды опций товаров
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\LibProductOption::class)
                    <li>
                        <a class="" href="{{ action('Lib\LibProductOptionController@getIndex') }}">
                            <i class="mdi mdi-alert-octagram"></i>
                            <span class="hide-menu">
                                Опции товаров
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\LibCompanyCat::class)
                    <li>
                        <a class="" href="{{ action('Lib\LibCompanyCatController@getIndex') }}">
                            <i class="mdi mdi-alert-octagram"></i>
                            <span class="hide-menu">
                                Формы собственности
                            </span>
                        </a>
                    </li>
                @endcan
                @can('list', App\Model\SysAuthLog::class)
                    <li class="nav-small-cap">Системные</li>
                    <li>
                        <a class="" href="{{ action('System\AuthLogController@getIndex') }}">
                            <i class="mdi mdi-account-check"></i>
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