<!-- Navbar Start -->
<nav class="navbar navbar-light navbar-expand-lg bg-body-tertiary">
	<div class="container-fluid">
		<a class="navbar-brand" href="#"><h3>TaGET</h3></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link {{ str_contains(request()->route()->getName(), 'homepage') ? 'active' : '' }}" aria-current="page" href="{{ route('homepage') }}">Home</a>
				</li>
				<li class="nav-item">
				<a class="nav-link {{ str_contains(request()->route()->getName(), 'trading') ? 'active' : '' }}" aria-current="page" href="{{ route('trading', ['zone_id' => -1, 'energy_id' => -1]) }}">Trading</a>
				</li>
			</ul>
		</div>
		<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
				<a class="nav-link {{ str_contains(request()->route()->getName(), 'login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
				</li>
				<li class="nav-item">
				<a class="nav-link {{ str_contains(request()->route()->getName(), 'register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- Navbar END -->
