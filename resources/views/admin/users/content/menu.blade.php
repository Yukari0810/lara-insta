<ul class="list-group">
    <a href="{{route('admin.index')}}" class="list-group-item {{ request()->is('admin/user') ? 'active' : '' }}" aria-current="true">
        <i class="fa-solid fa-users"></i> Users
    </a>
    <a href="{{route('admin.posts')}}" class="list-group-item {{ request()->is('admin/posts') ? 'active' : '' }}" aria-current="true">
        <i class="fa-solid fa-newspaper"></i> Posts
    </a>
    <a href="{{route('admin.categories')}}" class="list-group-item {{ request()->is('admin/categories') ? 'active' : '' }}" aria-current="true">
        <i class="fa-solid fa-tag"></i> Categories
    </a>
  </ul>
