  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(route('dashboard')); ?>" class="brand-link">
      <img src="<?php echo e(asset('images/logo/logo.png')); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sai</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo e(route('roles.index')); ?>" class="nav-link <?php echo e(request()->routeIs('roles.index') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Roles
              </p>
            </a>
          </li>

          <li class="nav-item">
                <a href="<?php echo e(route('permissions.index')); ?>" class="nav-link <?php echo e(request()->routeIs('permissions.*') ? 'active' : ''); ?>">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Permission</p>
                </a>
            </li>

          <li class="nav-item">
            <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('users.index') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Users
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo e(route('admin.media.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.media.index') ? 'active' : ''); ?>">
             <i class="nav-icon fas fa-copy"></i>
              <p>
                Media
              </p>
            </a>
          </li>

          <li class="nav-item <?php echo e(request()->routeIs('sliders.*') ? 'menu-open' : ''); ?>">
              <a href="#" class="nav-link <?php echo e(request()->routeIs('sliders.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Page Management
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>

              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?php echo e(route('campaigns.index')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('campaigns.index') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Pages</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="<?php echo e(route('campaigns.miniCampaignIndex')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('campaigns.miniCampaignIndex') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Mini Campaign</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="<?php echo e(route('sliders.index')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('sliders.index') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Sliders</p>
                      </a>
                  </li>

                   <li class="nav-item <?php echo e(request()->routeIs('sponsors.index') ? 'menu-open' : ''); ?> ">
                        <a href="<?php echo e(route('sponsors.index')); ?>" class="nav-link <?php echo e(request()->routeIs('sponsors.index') ? 'active' : ''); ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p> Images </p>
                        </a>
                    </li>

                    <li class="nav-item <?php echo e(request()->routeIs('values.index') ? 'menu-open' : ''); ?> ">
                        <a href="<?php echo e(route('values.index')); ?>" class="nav-link <?php echo e(request()->routeIs('values.index') ? 'active' : ''); ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Our Values </p>
                        </a>
                    </li>

                    <li class="nav-item <?php echo e(request()->routeIs('reviews.index') ? 'menu-open' : ''); ?> ">
                        <a href="<?php echo e(route('reviews.index')); ?>" class="nav-link <?php echo e(request()->routeIs('reviews.index') ? 'active' : ''); ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Reviews </p>
                        </a>
                    </li>
              </ul>
          </li>







           <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Report
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>

              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?php echo e(route('stories.index')); ?>"
                        class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Posts</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="<?php echo e(route('categories.index')); ?>" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Categories</p>
                      </a>
                  </li>
              </ul>
          </li>

           <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Tools
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>

              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?php echo e(route('menu.index')); ?>"
                        class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Menu Bulilder</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.database.index')); ?>"
                        class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Database</p>
                      </a>
                  </li>

                  <!-- <li class="nav-item">
                      <a href="#"
                        class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Compase</p>
                      </a>
                  </li> -->

                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.database.breadindex')); ?>"
                        class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Bread</p>
                      </a>
                  </li>

                  <!-- <li class="nav-item">
                      <a href="#"
                        class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Hooks</p>
                      </a>
                  </li> -->
              </ul>
          </li>

          <li class="nav-item <?php echo e(request()->routeIs('admin.campaign.gallery.index') ? 'menu-open' : ''); ?>">
              <a href="<?php echo e(route('campaign.gallery.index')); ?>" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Gallery Editor </p>
              </a>
          </li>
            <li class="nav-item <?php echo e(request()->routeIs('google_analytics.*') ? 'menu-open' : ''); ?>">
              <a href="#" class="nav-link <?php echo e(request()->routeIs('google_analytics.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      SEO Management
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>

              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.google_analytics')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.google_analytics') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>  Analytics  </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.sitemapForm')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.sitemapForm') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>  Sitemap </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.google_console')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.google_console') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Google Search Console </p>
                      </a>
                  </li>

                   <li class="nav-item <?php echo e(request()->routeIs('admin.tag_manager_form') ? 'menu-open' : ''); ?> ">
                        <a href="<?php echo e(route('admin.tag_manager_form')); ?>" class="nav-link <?php echo e(request()->routeIs('tag_manager_form') ? 'active' : ''); ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>  Tag Manager  </p>
                        </a>
                    </li>

              </ul>
            </li>
           <li class="nav-item <?php echo e(request()->routeIs('sitemap.*') ? 'menu-open' : ''); ?>">
              <a href="#" class="nav-link <?php echo e(request()->routeIs('sitemap.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Settings
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>

              <ul class="nav nav-treeview">
                  
              </ul>

              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?php echo e(route('websitesetting')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('websitesetting') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Settings</p>
                      </a>
                  </li>
              </ul>
          </li>

        

          <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Subscribers & Message
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>

              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.subscriberList')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.subscriberList') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Subscribers</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.contactMessage')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.contactMessage') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Contact message</p>
                      </a>
                  </li>

              </ul>
          </li>


          
          <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Language
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>

              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.languages')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.languages') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Language</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="<?php echo e(route('admin.translations')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.translations') ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Translation</p>
                      </a>
                  </li>

              </ul>
          </li>






          <!-- <li class="nav-item <?php echo e(request()->routeIs('campaigns.index') ? 'menu-open' : ''); ?> ">
              <a href="<?php echo e(route('campaigns.index')); ?>" class="nav-link <?php echo e(request()->routeIs('campaigns.index') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Pages </p>
              </a>
          </li> -->

          <!-- <li class="nav-item <?php echo e(request()->routeIs('stories.index') ? 'menu-open' : ''); ?> ">
              <a href="<?php echo e(route('stories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('stories.index') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Stories </p>
              </a>
          </li> -->

          <!-- <li class="nav-item <?php echo e(request()->routeIs('websitesetting') ? 'menu-open' : ''); ?> ">
              <a href="<?php echo e(route('websitesetting')); ?>" class="nav-link <?php echo e(request()->routeIs('websitesetting') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Website Settings </p>
              </a>
          </li> -->


          <!-- <li class="nav-item <?php echo e(request()->routeIs('admin.pages') ? 'menu-open' : ''); ?> ">
              <a href="<?php echo e(route('admin.pages')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.pages') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Pages </p>
              </a>
          </li> -->

        


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<?php /**PATH /home/saingo/public_html/resources/views/admin/layouts/aside.blade.php ENDPATH**/ ?>