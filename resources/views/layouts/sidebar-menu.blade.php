<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt green"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/profile" class="nav-link">
          <i class="nav-icon fas fa-user-cog green"></i>
          <p>
            My Profile
          </p>
        </router-link>
      </li>

            <!-- ---------- My Office Begins ---------- -->
      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-briefcase orange"></i>
          <p>
            My Office
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <router-link to="/assessments" class="nav-link">
              <i class="nav-icon fas fa-spell-check green"></i>
              <p>
                Students Assessments
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/assessments" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher green"></i>
              <p>
                My Classrooms
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/assessments" class="nav-link">
              <i class="nav-icon fas fa-clone green"></i>
              <p>
                My Subjects
              </p>
            </router-link>
          </li>


        </ul>
      </li>
      @endcan
      <!-- ---------- My Office Ends ---------- -->

      <!-- ---------- School Services Begins ---------- -->
      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon 	fas fa-laptop-house orange"></i>
          <p>
              School Services 
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/student-result" class="nav-link">
              <i class="nav-icon fas fa-award green"></i>
              <p>
                Students Result
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/codes" class="nav-link">
              <i class="nav-icon fas fa-code green"></i>
              <p>
                Code Generator
              </p>
            </router-link>
          </li>

        </ul>
      @endcan
      <!-- ---------- School Services Ends ---------- -->



      <!-- ---------- Setup and Basic Configurations ---------- -->
      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-tools orange"></i>
          <p>
              Setup & Configurations 
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <i class="nav-icon fas fa-users green"></i>
              <p>
                School Users
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/sections" class="nav-link">
              <i class="nav-icon fas fa-chart-pie green"></i>
              <p>
                School Sections
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/departments" class="nav-link">
              <i class="nav-icon fas fa-city green"></i>
              <p>
                School Departments
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/classrooms" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher green"></i>
              <p>
                School Classrooms
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/subjects" class="nav-link">
              <i class="nav-icon fas fa-clone green"></i>
              <p>
                School Subjects
              </p>
            </router-link>
          </li>

        </ul>
      </li>
      @endcan


      <!-- ---------- My Office Begins ---------- --
      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-briefcase green"></i>
          <p>
            My Office
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher green"></i>
              <p>
                School Sections
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-user-graduate green"></i>
              <p>
                School Classes
              </p>
            </router-link>
          </li>
          
            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-users green"></i>
                  <p>
                      School Users
                  </p>
              </router-link>
            </li>

        </ul>
      </li>
      @endcan
      <!-- ---------- My Office Ends ---------- --


      <!-- ---------- My Area Begins ---------- --
      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-tie green"></i>
          <p>
            My Area
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

        <li class="nav-item">
            <router-link to="/under-construction" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher green"></i>
              <p>
                My Classes
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/under-construction" class="nav-link">
              <i class="nav-icon fas fa-user-graduate green"></i>
              <p>
                My Students
              </p>
            </router-link>
          </li>
          
            <li class="nav-item">
              <router-link to="/under-construction" class="nav-link">
                  <i class="nav-icon fas fa-users green"></i>
                  <p>
                      My Colleagues
                  </p>
              </router-link>
            </li>

        </ul>
      </li>
      @endcan
      <!-- ---------- My Area Ends ---------- -->


      <!-- ---------- My Services Begins ---------- --
      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon 	fas fa-tasks green"></i>
          <p>
            My Services
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                My Classes
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                My Students
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs white"></i>
                <p>
                    My Colleagues
                </p>
            </router-link>
          </li>
        </ul>
      </li>
      @endcan
      <!-- ---------- My Services Ends ---------- --


      <!-- ---------- All Services Begins ---------- --
      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-th-list green"></i>
          <p>
            Other Services
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                My Classes
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                My Students
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs white"></i>
                <p>
                    My Colleagues
                </p>
            </router-link>
          </li>
        </ul>
      </li>
      @endcan
      <!-- ---------- All Services Ends ---------- --


      <!-- ---------- All Settings Begins ---------- --
      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            All Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Category
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                Tags
              </p>
            </router-link>
          </li>
          
            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li>
        </ul>
      </li>
      @endcan
      <!-- ---------- All Settings Ends ---------- -->

      

      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>