<?php
$activePage = isset($activePage) ? $activePage : '';
$adminBase  = defined('SITE_URL') ? SITE_URL . '/admin/' : '/rkhospital/admin/';

function sbActive($key, $active)  { return $active === $key ? ' class="active"' : ''; }
function sbParent($keys, $active) { return in_array($active,(array)$keys) ? ' class="submenu active"' : ' class="submenu"'; }
function sbOpen($keys, $active)   { return in_array($active,(array)$keys) ? 'block' : 'none'; }
?>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title"><span>Main</span></li>

                <li<?= sbActive('dashboard',$activePage) ?>>
                    <a href="<?= $adminBase ?>index.php">
                        <i class="fe fe-home"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Hospital</span></li>

                <li<?= sbParent('doctors',$activePage) ?>>
                    <a href="#"><i class="fe fe-user-plus"></i> <span>Doctors</span> <span class="menu-arrow"></span></a>
                    <ul style="display:<?= sbOpen('doctors',$activePage) ?>;">
                        <li><a href="<?= $adminBase ?>doctors/index.php">All Doctors</a></li>
                        <li><a href="<?= $adminBase ?>doctors/add.php">Add Doctor</a></li>
                    </ul>
                </li>

                <li<?= sbParent('users',$activePage) ?>>
                    <a href="#"><i class="fe fe-users"></i> <span>Users</span> <span class="menu-arrow"></span></a>
                    <ul style="display:<?= sbOpen('users',$activePage) ?>;">
                        <li><a href="<?= $adminBase ?>users/index.php">All Users</a></li>
                        <li><a href="<?= $adminBase ?>users/add.php">Add User</a></li>
                    </ul>
                </li>

                <li class="menu-title"><span>Content</span></li>

                <li<?= sbParent('blogs',$activePage) ?>>
                    <a href="#"><i class="fe fe-edit"></i> <span>Blogs</span> <span class="menu-arrow"></span></a>
                    <ul style="display:<?= sbOpen('blogs',$activePage) ?>;">
                        <li><a href="<?= $adminBase ?>blog/index.php">All Blogs</a></li>
                        <li><a href="<?= $adminBase ?>blog/add.php">Add Blog</a></li>
                    </ul>
                </li>

                <li<?= sbParent('services',$activePage) ?>>
                    <a href="#"><i class="fe fe-briefcase"></i> <span>Services</span> <span class="menu-arrow"></span></a>
                    <ul style="display:<?= sbOpen('services',$activePage) ?>;">
                        <li><a href="<?= $adminBase ?>services/index.php">All Services</a></li>
                        <li><a href="<?= $adminBase ?>services/add.php">Add Service</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
