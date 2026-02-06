          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Notification Bell -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <i class="bx bx-bell bx-sm text-slate-600"></i>
                    <span class="badge bg-danger rounded-pill badge-notifications">0</span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom">
                      <div class="dropdown-header d-flex align-items-center py-3">
                        <h5 class="text-body mb-0 me-auto fw-bold">Notifications</h5>
                        <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read">
                          <i class="bx bx-envelope-open text-heading"></i>
                        </a>
                      </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                  <i class="bx bx-bell"></i>
                                </span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1 fw-semibold">No new notifications</h6>
                              <p class="mb-0 small text-muted">You're all caught up!</p>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online me-2" style="width: 40px; height: 40px;">
                      <span class="avatar-initial rounded-circle bg-primary fw-bold text-white">
                        {{ substr(Auth::user()->name, 0, 2) }}
                      </span>
                    </div>
                    <div class="d-none d-md-block">
                      <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
                      <small class="text-muted d-block">{{ Auth::user()->email }}</small>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end mt-2 shadow">
                    <li class="dropdown-item py-3 px-4">
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                          <span class="avatar-initial rounded-circle bg-primary fw-bold text-white">
                            {{ substr(Auth::user()->name, 0, 2) }}
                          </span>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-bold d-block text-dark">{{ Auth::user()->name }}</span>
                          <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                      </div>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                      <a class="dropdown-item py-2 px-4 d-flex align-items-center" href="#">
                        <i class="bx bx-user me-3"></i>
                        <span>My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item py-2 px-4 d-flex align-items-center" href="#">
                        <i class="bx bx-cog me-3"></i>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                      <a class="dropdown-item py-2 px-4 d-flex align-items-center"
                         href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off me-3"></i>
                        <span>Log Out</span>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>