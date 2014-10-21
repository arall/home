<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
     <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Links -->
        <div class="navbar-collapse collapse">

            <!-- Left -->
            <ul class="nav navbar-nav">
                <li {{ (Request::is('/') ? ' class="active"' : '') }}>
                    <a href="{{{ URL::to('/') }}}">
                        Home
                    </a>
                </li>
                @if(Auth::user())
                    <li>
                        {{ HTML::link(route('storages.index'), 'Storages') }}
                    </li>
                    @if(Auth::user()->role_id == 1)
                        <li>
                            <a href="{{{ URL::action('AdminUsersController@getUsers') }}}">
                                Users
                            </a>
                        </li>
                    @endif
                @endif
            </ul>

            <!-- Right -->
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li>
                        <a href="{{{ URL::route('login') }}}">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{{ URL::route('register') }}}">
                            Register
                        </a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{{ Auth::user()->username }}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{{ URL::action('AccountController@getAccount') }}}">
                                    Account
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{{ URL::route('logout') }}}">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- ./ navbar -->
