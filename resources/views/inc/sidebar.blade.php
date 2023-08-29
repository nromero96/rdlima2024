<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{ route('dashboard.index') }}">
                        <img src="{{ asset('assets/img/logo.png') }}" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text text-center">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">RADLA 2024</a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>

        <div class="shadow-bottom"></div>

        <ul class="list-unstyled menu-categories" id="menudashboardaccordion">

            {{-- <li class="menu {{ ($category_name === 'dashboard') ? 'active' : '' }}">
                <a href="#dashboard" data-bs-toggle="collapse" aria-expanded="{{ ($category_name === 'dashboard') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>{{ __("Dashboard") }}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ ($category_name === 'dashboard') ? 'show' : '' }}" id="dashboard" data-bs-parent="#menudashboardaccordion">
                    <li class="{{ ($page_name === 'analytics') ? 'active' : '' }}">
                        <a href="{{route('dashboard.analytics')}}"> {{ __("Analytics") }} </a>
                    </li>
                    <li class="{{ ($page_name === 'sales') ? 'active' : '' }}">
                        <a href="{{route('dashboard.sales')}}"> {{ __("Sales") }} </a>
                    </li>
                </ul>
            </li> --}}

            <li class="menu {{ ($category_name === 'profile') ? 'active' : '' }}">
                <a href="{{ route('users.myprofile') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" viewBox="0 0 24 24" stroke-linejoin="round"><path d="M12 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path><path d="M21 22a9 9 0 1 0-18 0"></path><path d="m15 18-4 4-2-2"></path></svg>
                        <span> {{ __("Información Personal") }} </span>
                    </div>
                </a>
            </li>


            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>{{__("GESTION")}}</span></div>
            </li>

            @can('users.index')
            <li class="menu {{ ($category_name === 'users') ? 'active' : '' }}">
                <a href="{{route('users.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>{{ __("Usuarios") }}</span>
                    </div>
                </a>
            </li>
            @endcan

            @can('roles.index')
            <li class="menu {{ ($category_name === 'roles') ? 'active' : '' }}">
                <a href="{{route('roles.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-toggle-left"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"/><circle cx="8" cy="12" r="3"/></svg>
                        <span>{{ __("Roles & Permisos") }}</span>
                    </div>
                </a>
            </li>
            @endcan

            <li class="menu {{ ($category_name === 'roles') ? 'active-dd' : '' }}">
                <a href="{{route('roles.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 10H9v4h10v-4Z"></path><path d="M16 3H9v4h7V3Z"></path><path d="M22 17H9v4h13v-4Z"></path><path d="M8.5 5h-6"></path><path d="M8.5 12h-6"></path><path d="M8.5 19h-6"></path><path d="M2.5 22V2"></path></svg>
                        <span>{{ __("Programa") }}</span>
                    </div>
                </a>
            </li>

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>{{__("EVENTO")}}</span></div>
            </li>

            <li class="menu {{ ($category_name === 'roles') ? 'active-dd' : '' }}">
                <a href="{{route('roles.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19.5 3h-15A1.5 1.5 0 0 0 3 4.5v15A1.5 1.5 0 0 0 4.5 21h15a1.5 1.5 0 0 0 1.5-1.5v-15A1.5 1.5 0 0 0 19.5 3Z"></path><path d="M10.5 6.5h-4v4h4v-4Z"></path><path d="M10.5 13.5h-4v4h4v-4Z"></path><path d="M13.5 14h4"></path><path d="M13.5 17.5h4"></path><path d="M13.5 6.5h4"></path><path d="M13.5 10h4"></path></svg>
                        <span>{{ __("Inscripciones") }}</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ ($category_name === 'roles') ? 'active-dd' : '' }}">
                <a href="{{route('roles.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"><path d="M2 2h20"></path><path d="M19 2H5a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1Z"></path><path d="M10 16h4v6h-4v-6Z"></path><path d="M7.5 6h1"></path><path d="M7.5 9h1"></path><path d="M11.5 6h1"></path><path d="M11.5 9h1"></path><path d="M15.5 6h1"></path><path d="M15.5 9h1"></path><path d="M2 22h20"></path><path d="M14 16h1c.276 0 .505-.226.452-.497C15.176 14.083 13.735 13 12 13c-1.736 0-3.176 1.083-3.452 2.503-.053.271.176.497.452.497h1"></path></svg>
                        <span>{{ __("Alojamientos") }}</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ ($category_name === 'roles') ? 'active-dd' : '' }}">
                <a href="{{route('roles.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>{{ __("Trabajos") }}</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ ($category_name === 'roles') ? 'active-dd' : '' }}">
                <a href="{{route('roles.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>{{ __("Expositores/Expertos") }}</span>
                    </div>
                </a>
            </li>

            {{-- <li class="menu {{ ($category_name === 'quotations') ? 'active' : '' }}">
                <a href="#datatables" data-bs-toggle="collapse" aria-expanded="{{ ($category_name === 'quotations') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>{{ __("Quotations") }}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ ($category_name === 'quotations') ? 'show' : '' }}" id="datatables" data-bs-parent="#menudashboardaccordion">
                    <li class="{{ ($page_name === 'quotationscommercial') ? 'active' : '' }}">
                        <a href="{{route('quotations.commercial')}}"> {{ __("Commercials") }} </a>
                    </li>

                    <li class="{{ ($page_name === 'quotationspersonal') ? 'active' : '' }}">
                        <a href="{{route('quotations.personal')}}"> {{ __("Personals") }} </a>
                    </li>
                </ul>
            </li> --}}

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>{{__('OTROS')}}</span></div>
            </li>

            <li class="menu {{ ($page_name === 'invitations') ? 'active' : '' }}">
                <a href="{{route('invitations.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 11.5V7l-4.5-5H5a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h6"></path><path d="M15.425 15c-1.063 0-1.925 1.004-1.925 2.243 0 2.243 2.275 4.283 3.5 4.757 1.225-.474 3.5-2.514 3.5-4.757 0-1.239-.862-2.243-1.925-2.243-.651 0-1.227.377-1.575.953-.348-.576-.924-.953-1.575-.953Z"></path><path d="M15 2v5h5"></path></svg>
                        <span> {{ __("Carta de invitación") }} </span>
                    </div>
                </a>
            </li>

            <li class="menu {{ ($category_name === 'roles') ? 'active--dd' : '' }}">
                <a href="{{route('roles.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>{{ __("Código Especial") }}</span>
                    </div>
                </a>
            </li>

            {{-- <li class="menu {{ ($page_name === 'calendar') ? 'active' : '' }}">
                <a href="{{route('calendars.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>{{ __('Calendario') }}</span>
                        <span class="badge badge-primary sidebar-label"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle badge-icon"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg> {{__('New')}}</span>
                    </div>
                </a>
            </li> --}}

            {{-- <li class="menu {{ ($page_name === 'notes') ? 'active' : '' }}">
                <a href="{{route('notes.index')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>{{ __("Notas") }}</span>
                    </div>
                </a>
            </li> --}}

        </ul>
    </nav>

</div>