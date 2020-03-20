<div class="user-profile">
    <div class="profile-text">
        <h5>{!! Auth::user()->getTypeName() !!}</h5>
    </div>
    <div class="profile-img" style="
        background: url({{ Auth::user()->photo ? Auth::user()->photo : '/assets/images/users/user-default-1.svg' }});
        background-size: cover !important;
        background-repeat: no-repeat !important;
        background-position: 50% !important;

        width: 55px;
        height: 55px;
    ">
        <img sda="{{ Auth::user()->photo ? Auth::user()->photo : '/assets/images/users/user-default-1.svg' }}" alt="user" style="display: none;">
    </div>
    <div class="profile-text">
        <h6>{{ Auth::user()->name }}</h6>
        <a href="{{ action('ProfileController@getIndex') }}" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
        <a href="{{ action('LoginController@getLogout') }}" class="" data-toggle="tooltip" title="" data-original-title="Logout"><i class="mdi mdi-power"></i></a>

        <div class="dropdown-menu animated flipInY">
            <a href="{{ action('ProfileController@getIndex') }}" class="dropdown-item"><i class="ti-settings"></i>Профиль</a>
            <div class="dropdown-divider"></div>
            <a href="{{ action('LoginController@getLogout') }}" class="dropdown-item"><i class="fa fa-power-off"></i> Выйти</a>
        </div>
    </div>
</div>
