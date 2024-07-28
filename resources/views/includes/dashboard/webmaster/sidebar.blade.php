        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
            <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="./index.html" class="brand-link">
                    <!--begin::Brand Image--> <i class="nav-icon bi bi-speedometer"></i> <!--end::Brand Image-->
                    <!--begin::Brand Text--> <span class="brand-text fw-light">Dashboard</span> <!--end::Brand Text-->
                </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2"> <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item"> <a href="{{route('dashboard.webmaster.profile')}}" class="nav-link"> <i
                                    class="nav-icon bi bi-person-fill" style="font-size: 1.3rem; color: cornflowerblue;"></i>
                                <p>Profile</p>
                            </a></li>
                        <li class="nav-item"> <a href="{{route('dashboard.webmaster.subscriptions')}}" class="nav-link"> <i
                                    class="nav-icon bi bi-star" style="font-size: 1.3rem; color: cornflowerblue;"></i>
                                <p>Subscriptions</p>
                            </a></li>
                        <li class="nav-item"> <a href="" class="nav-link"> <i
                                    class="nav-icon bi bi-arrow-left-right"
                                    style="font-size: 1.3rem; color: cornflowerblue;"></i>
                                <p>Redirects</p>
                            </a></li>
                        <li class="nav-item"> <a href="{{route('dashboard.webmaster.statistics')}}" class="nav-link"> <i
                                    class="nav-icon bi bi-table" style="font-size: 1.3rem; color: cornflowerblue;"></i>
                                <p>Statistics</p>
                            </a></li>
                            <li class="nav-item"> <a href="{{route('dashboard.webmaster.wallet')}}" class="nav-link"> <i
                                    class="nav-icon bi bi-wallet2" style="font-size: 1.3rem; color: cornflowerblue;"></i>
                                <p>Wallet</p>
                            </a></li>
                    </ul> <!--end::Sidebar Menu-->
                </nav>
            </div> <!--end::Sidebar Wrapper-->
        </aside> <!--end::Sidebar--> <!--begin::App Main-->
