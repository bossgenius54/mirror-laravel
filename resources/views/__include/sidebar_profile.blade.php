<div class="user-profile">
    <div class="profile-img"> 
        <img src="{{ Auth::user()->photo ? Auth::user()->photo : '/assets/images/users/1.jpg' }}" alt="user" style="width: 58px; height: 50px;"> 
        <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
    </div>
    <div class="profile-text"> 
        <h5>{{ Auth::user()->name }}</h5>
        <h6>{!! Auth::user()->getTypeName() !!}</h6>
        <a href="{{ action('ProfileController@getIndex') }}" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
        <a href="{{ action('LoginController@getLogout') }}" class="" data-toggle="tooltip" title="" data-original-title="Logout"><i class="mdi mdi-power"></i></a>

        <div class="dropdown-menu animated flipInY">
            <a href="{{ action('ProfileController@getIndex') }}" class="dropdown-item"><i class="ti-settings"></i>Профиль</a>
            <div class="dropdown-divider"></div>
            <a href="{{ action('LoginController@getLogout') }}" class="dropdown-item"><i class="fa fa-power-off"></i> Выйти</a>
        </div>
    </div>
</div>