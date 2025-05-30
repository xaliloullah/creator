@extends('admin.index') 
@section('content')
    <!-- Main Content -->

        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3">Dashboard</h1>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">
                                    Total Sales
                                </h6>
                                <h3 class="mb-0">$24,500</h3>
                            </div>
                            <div class="text-primary">
                                <i class="bi bi-currency-dollar fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">
                                    Active Users
                                </h6>
                                <h3 class="mb-0">1,250</h3>
                            </div>
                            <div class="text-success">
                                <i class="bi bi-people fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">
                                    New Orders
                                </h6>
                                <h3 class="mb-0">342</h3>
                            </div>
                            <div class="text-warning">
                                <i class="bi bi-cart fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">
                                    Growth
                                </h6>
                                <h3 class="mb-0">+24.5%</h3>
                            </div>
                            <div class="text-info">
                                <i class="bi bi-graph-up fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Tasks -->
        <div class="row g-4">
            <!-- Recent Activity -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            Recent Activity
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Activity</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sarah Johnson</td>
                                        <td>New order placed</td>
                                        <td>2 min ago</td>
                                        <td>
                                            <span class="badge bg-success">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mike Anderson</td>
                                        <td>Payment received</td>
                                        <td>15 min ago</td>
                                        <td>
                                            <span class="badge bg-primary">Processed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lisa Williams</td>
                                        <td>Account created</td>
                                        <td>1 hour ago</td>
                                        <td>
                                            <span class="badge bg-info">New</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tom Wilson</td>
                                        <td>
                                            Support ticket opened
                                        </td>
                                        <td>2 hours ago</td>
                                        <td>
                                            <span class="badge bg-warning">Pending</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">Tasks</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="task1" />
                                    <label class="form-check-label" for="task1">
                                        Review new orders
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item px-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="task2" />
                                    <label class="form-check-label" for="task2">
                                        Update inventory
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item px-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="task3" />
                                    <label class="form-check-label" for="task3">
                                        Respond to support tickets
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item px-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="task4" />
                                    <label class="form-check-label" for="task4">
                                        Prepare monthly report
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
