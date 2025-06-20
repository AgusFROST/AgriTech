<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">
                <i class="fas fa-leaf text-secondary mb-2" style="font-size: 2rem;"></i>
                AgriTech
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('dashboard') ? 'active' : '' }}"
                        href="/dashboard">
                        <i class="bi bi-graph-up-arrow"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('dashboard/peta-interaktif') ? 'active' : '' }}"
                        href="/dashboard/peta-interaktif">
                        <i class="fas fa-seedling"></i>
                        Lahan
                    </a>
                </li>
            </ul>


            @if (auth()->user()->role->name === 'Administrator')
                <h6
                    class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
                    <span>Administrator</span>
                    <a class="link-secondary" href="#" aria-label="Add a new report">
                        <svg class="bi">
                            <use xlink:href="#plus-circle" />
                        </svg>
                    </a>
                </h6>
                <ul class="nav flex-column mb-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('dashboard/users-management') ? 'active' : '' }}"
                            href="/dashboard/users-management">
                            <svg class="bi">
                                <use xlink:href="#people" />
                            </svg>
                            Users Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('dashboard/ndvi-map') ? 'active' : '' }}"
                            href="/dashboard/ndvi-map">
                            <svg class="bi">
                                <use xlink:href="#file-earmark-text" />
                            </svg>
                            NDVI Map Analysis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('dashboard/ndvi-update') ? 'active' : '' }}"
                            href="/dashboard/ndvi-update">
                            <svg class="bi">
                                <use xlink:href="#file-earmark-text" />
                            </svg>
                            NDVI Update
                        </a>
                    </li>
                </ul>
            @endif

            <hr class="my-3">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('dashboard/settings') ? 'active' : '' }}"
                        href="/dashboard/settings">
                        <svg class="bi">
                            <use xlink:href="#gear-wide-connected" />
                        </svg>
                        Settings
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link d-flex align-items-center gap-2 border-0 bg-transparent">
                            <svg class="bi">
                                <use xlink:href="#door-closed" />
                            </svg>
                            Sign out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
