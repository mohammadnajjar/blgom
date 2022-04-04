<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
    <div class="wn__sidebar">
        <!-- Start Single Widget -->
        <aside class="widget archives_widget">
            <ul>
                <li class="list-group-item">
                    <img src="{{asset('assets/users/defualt.png')}}" alt="{{auth()->user()->name}}">
                </li>
                <li class="list-group-item"><a href="{{ route('dashboard') }}">My Posts</a></li>
                <li class="list-group-item"><a href="{{ route('users.create_post') }}">Create Post</a></li>
                <li class="list-group-item"><a href="{{ route('users.show.comments') }}">Manage Comments</a></li>
                <li class="list-group-item"><a href="{{ route('dashboard') }}">Update Information</a></li>
                <li class="list-group-item"><a href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </li>
            </ul>
        </aside>
    </div>

    </ul>
    </aside>
    <!-- End Single Widget -->
</div>
</div>
