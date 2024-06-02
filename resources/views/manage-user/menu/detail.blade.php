<x-app-layout>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ $title ?? ''}}
                    </h2>
                    <div class="text-muted mt-1">{{ $menuItems->count()}} Total</div>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    {{-- <div class="d-flex">
                        <select type="text" class="form-select me-3" id="select-by-application">
                            <option selected disabled>-- Select By Application --</option>
                            @foreach($applications as $application)
                            <option value="{{ $application->id }}">{{ $application->name }}(
                    <span style="color: #6c757d;">({{ $application->status }}</span>)</option>
                    @endforeach
                    </select> --}}
                    <a href="#" class="btn btn-primary">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" /></svg>
                        New SubMenu
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Route</th>
                                        <th>Permission</th>
                                        <th>Number</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menuItems as $menuItem)
                                    <tr>
                                        <td>{{ $menuItem->name}}</td>
                                        <td>
                                            {{ $menuItem->route ? $menuItem->route : '#'}}
                                        </td>
                                        <td class="text-muted">
                                            {{ $menuItem->permission ? $menuItem->permission->name : ''}}
                                        </td>
                                        <td>
                                            {{ $menuItem->serial_number ?? ''}}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">
                                                        Edit
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        Delete
                                                    </a>
                                                </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
