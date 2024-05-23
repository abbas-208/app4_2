<nav class="navbar navbar-light navbar-expand-lg bg-body-tertiary bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <button class="btn btn-outline-primary">
            @if (Auth::user()->isActivated)
              User status: <span class="badge bg-primary bg-gradient">Active</span>
            @else
              User status: <span class="badge bg-danger bg-gradient">Deactivated</span>
            @endif
          </button>
        </div>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      <i class="fas fa-user-circle" style="font-size:1rem;color: darkgreen"></i> {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
  </nav>
