  <header id="header" class="header d-flex align-items-center sticky-top">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">

          <a href="index.html" class="logo d-flex align-items-center me-auto">
              <!-- Uncomment the line below if you also wish to use an image logo -->
              <img src="assets/client/img/logo/blis-white.png" alt="">
              {{-- <h1 class="sitename">Learner</h1> --}}
          </a>

          {{-- <nav id="navmenu" class="navmenu">
              <ul>
                  <li><a href="index.html" class="active">Home</a></li>
                  <li><a href="about.html">About</a></li>
                  <li><a href="courses.html">Courses</a></li>
                  <li><a href="instructors.html">Instructors</a></li>
                  <li><a href="pricing.html">Pricing</a></li>
                  <li><a href="blog.html">Blog</a></li>
                  <li class="dropdown"><a href="#"><span>More Pages</span> <i
                              class="bi bi-chevron-down toggle-dropdown"></i></a>
                      <ul>
                          <li><a href="course-details.html">Course Details</a></li>
                          <li><a href="instructor-profile.html">Instructor Profile</a></li>
                          <li><a href="events.html">Events</a></li>
                          <li><a href="blog-details.html">Blog Details</a></li>
                          <li><a href="terms.html">Terms</a></li>
                          <li><a href="privacy.html">Privacy</a></li>
                          <li><a href="404.html">404</a></li>
                      </ul>
                  </li>

                  <li class="dropdown"><a href="#"><span>Dropdown</span> <i
                              class="bi bi-chevron-down toggle-dropdown"></i></a>
                      <ul>
                          <li><a href="#">Dropdown 1</a></li>
                          <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                      class="bi bi-chevron-down toggle-dropdown"></i></a>
                              <ul>
                                  <li><a href="#">Deep Dropdown 1</a></li>
                                  <li><a href="#">Deep Dropdown 2</a></li>
                                  <li><a href="#">Deep Dropdown 3</a></li>
                                  <li><a href="#">Deep Dropdown 4</a></li>
                                  <li><a href="#">Deep Dropdown 5</a></li>
                              </ul>
                          </li>
                          <li><a href="#">Dropdown 2</a></li>
                          <li><a href="#">Dropdown 3</a></li>
                          <li><a href="#">Dropdown 4</a></li>
                      </ul>
                  </li>
                  <li><a href="contact.html">Contact</a></li>
              </ul>
              <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
          </nav> --}}

          @auth
              <div class="dropdown">
                  <a class="btn-getstarted dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      {{ Auth::user()->name }}
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      @if (Auth::user()->role === 'admin')
                          <li><a class="dropdown-item" href="{{ route('admin.index') }}">Dashboard</a></li>
                      @elseif (Auth::user()->role === 'client')
                          <li><a class="dropdown-item" href="{{ route('client.index') }}">Dashboard</a></li>
                      @endif

                      <li>
                          <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <button type="submit" class="dropdown-item">Logout</button>
                          </form>
                      </li>
                  </ul>
              </div>
          @endauth

          @guest
              <a class="btn-getstarted" href="{{ route('login') }}">Login</a>
          @endguest


      </div>
  </header>
