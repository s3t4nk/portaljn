<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('hris.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light">Portal HRIS</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" id="dynamic-menu">

                @foreach ($menuItems as $item)
                    @if (isset($item['submenu']))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'menu-{{ $loop->index }}')">
                                <i class="nav-icon {{ $item['icon'] }}"></i>
                                <p>
                                    {{ $item['text'] }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" id="menu-{{ $loop->index }}" style="display: none; padding-left: 15px;">
                                @foreach ($item['submenu'] as $sub)
                                    @can($sub['can'] ?? '')
                                        <li class="nav-item">
                                            <a href="{{ url($sub['url']) }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>{{ $sub['text'] }}</p>
                                            </a>
                                        </li>
                                    @endcan
                                @endforeach
                            </ul>
                        </li>
                    @else
                        @can($item['can'] ?? '')
                            <li class="nav-item">
                                <a href="{{ url($item['url']) }}" class="nav-link">
                                    <i class="nav-icon {{ $item['icon'] }}"></i>
                                    <p>{{ $item['text'] }}</p>
                                </a>
                            </li>
                        @endcan
                    @endif
                @endforeach

            </ul>
        </nav>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const menu = document.getElementById('dynamic-menu');
    if (!menu) return;

    // Single-click expand/collapse
    document.querySelectorAll('.has-treeview > a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const parent = this.parentElement;
            const isOpen = parent.classList.contains('menu-open');

            parent.classList.toggle('menu-open');
            const subMenu = parent.querySelector('.nav-treeview');
            if (subMenu) {
                subMenu.style.display = isOpen ? 'none' : 'block';
            }
        });
    });

    // Buka submenu jika ada item aktif
    document.querySelectorAll('.nav-link.active').forEach(activeLink => {
        const parent = activeLink.closest('.has-treeview');
        if (parent) {
            parent.classList.add('menu-open');
            const sub = parent.querySelector('.nav-treeview');
            if (sub) sub.style.display = 'block';
        }
    });
});


</script>