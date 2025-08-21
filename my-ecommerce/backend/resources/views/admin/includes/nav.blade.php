<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item menu-open">
      <a href="{{route('dashboard')}}" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
    </li>


    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage User
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">6</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('user.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Users List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add User</p>
          </a>
        </li>
      </ul>
    </li>



    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Blocks
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('blocks.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Block List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('blocks.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Block</p>
          </a>
        </li>
      </ul>
    </li>



    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Categories
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('categories.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Category List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('categories.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add category</p>
          </a>
        </li>
      </ul>
    </li>



    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Page
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">6</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('pages.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Pages List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('pages.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Page</p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Slider
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">6</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('slider.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Slider List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('slider.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Slider</p>
          </a>
        </li>
      </ul>
    </li>


    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Role
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('roles.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Role List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('roles.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Role</p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Permission
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('permissions.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Permission List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('permissions.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Permission</p>
          </a>
        </li>
      </ul>
    </li>


    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Products
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('products.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Product List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('products.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Products</p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Attributes
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('attributes.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Attribute List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('attributes.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Attributes</p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Coupons
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('coupons.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Coupon List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('coupons.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Coupons</p>
          </a>
        </li>
      </ul>
    </li>

    {{-- <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Help Section
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">6</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('we-help.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Help List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('we-help.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add Help</p>
          </a>
        </li>
      </ul>
    </li> --}}

    <li class="nav-item">
      <a href="{{route('order.index')}}" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Order
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right"></span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('customers.index')}}" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Manage Customer
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right"></span>
        </p>
      </a>
    </li>