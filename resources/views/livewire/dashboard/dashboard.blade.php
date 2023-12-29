<x-app-layout>
    <x-slot name="title">
        {{ __('Home') }}
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item active" aria-current="page">{{ __('Home') }}</li>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="mb-4 col-12 col-md-5">
                <div class="card welcome">
                    <div class="card-body">
                        <h6><span class="fw-light">{{ __('Good morning!') }}</span> {{ auth()->user()->name }} 🎉</h6>
                        <p class="my-2 small">{{ __('Lorem ipsum dolor sit amet consectetur adipisicing.') }}</p>
                        <div class="d-flex">
                            <div class="quick-static-item">
                                <div class="flex-shrink-0 me-2">
                                    <span class="label-icon bg-label-danger"><i class="bx bx-layer"></i></span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6>{{ number_format(\App\Models\Post::get()->count()) }}</h6>
                                    <small>{{ __('Total Posts') }}</small>
                                </div>
                            </div>
                            <div class="quick-static-item">
                                <div class="flex-shrink-0 me-2">
                                    <span class="label-icon bg-label-success"><i
                                            class="bx bx-message-square-dots"></i></span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6>315</h6>
                                    <small>{{ __('Comments') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="" class="rounded-pill btn btn-sm btn-dark me-2">{{ __('Show Posts') }}</a>
                            <a href=""
                                class="rounded-pill btn btn-sm btn-outline-dark">{{ __('Create New Post') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Visits -->
            <div class="mb-4 col-12 col-md-4">
                <div class="card h-100">
                    <div class="p-0 card-body">
                        <div class="p-3 d-flex">
                            <div class="flex-shrink-0 me-3">
                                <span class="label-icon bg-label-primary"><i class="bx bx-bar-chart-alt-2"></i></span>
                            </div>
                            <div class="flex-grow-1 d-flex">
                                <div class="me-auto">
                                    <h6 class="fs-5">{{ number_format(856932) }}</h6>
                                    <small>{{ __('Total Visits') }}</small>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-bs-toggle="dropdown"><i
                                            class="bx bx-menu"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item">Action</a>
                                        <a href="#" class="dropdown-item">Another Action</a>
                                        <a href="#" class="dropdown-item">Something else</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="views-chart"></div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-12 col-md-3">
                <div class="card dropbox-card h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-2 text-white">Dropbox Storage</h5>
                        <h4 class="text-white">150GB</h4>
                      </div>
                      <div class="mt-2 mb-4">
                        <div class="avatar avatar-s">
                          <i class="bx bxl-dropbox"></i>
                        </div>
                      </div>
                      <small class="text-white">134,2GB of 150GB Users</small>
                      <div class="mt-2 mb-2 bg-transparent progress" style="height: 8px">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-light-primary" role="progressbar" style="width: 20%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>

        <div class="row">
            <!-- Latest Posts -->
            <div class="mb-4 col-12 col-md-8">
                <div class="card h-100">
                    <div class="card-header">
                        <h6>{{ __('Latest Posts') }}</h6>
                    </div>
                    <div class="p-0 card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Views') }}</th>
                                        <th>{{ __('Comments') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\Post::orderByDesc('id')->take(9)->get() as $post)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <a href="#">{{ str($post->title)->words(4) }}</a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-bar-chart-alt-2 me-1"></i>{{ number_format($post->views) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-comment-dots me-1"></i>0
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

            <!-- Visits By Browser -->
            <div class="mb-4 col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>{{ __('Visits By Browser') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="py-1 mb-3 d-flex">
                            <div class="flex-shrink-0 me-2">
                                <img src="{{ asset('dashboard/images/brands/chrome.png') }}" width="24"
                                    alt="">
                            </div>
                            <div class="flex-grow-1 d-flex">
                                <div>
                                    <span>Chrome</span>
                                    <small class="text-muted fs-10 d-block">Lorem ipsum dolor sit.</small>
                                </div>
                                <div class="ms-auto">
                                    <span>8.92K</span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 82%; background: #F97316" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-1 mb-3 d-flex">
                            <div class="flex-shrink-0 me-2">
                                <img src="{{ asset('dashboard/images/brands/firefox.png') }}" width="24"
                                    alt="">
                            </div>
                            <div class="flex-grow-1 d-flex">
                                <div>
                                    <span>Firefox</span>
                                    <small class="text-muted fs-10 d-block">Lorem ipsum dolor sit.</small>
                                </div>
                                <div class="ms-auto">
                                    <span>8.92K</span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 25%; background: #1b6285" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-1 mb-3 d-flex">
                            <div class="flex-shrink-0 me-2">
                                <img src="{{ asset('dashboard/images/brands/safari.png') }}" width="24"
                                    alt="">
                            </div>
                            <div class="flex-grow-1 d-flex">
                                <div>
                                    <span>Safari</span>
                                    <small class="text-muted fs-10 d-block">Lorem ipsum dolor sit.</small>
                                </div>
                                <div class="ms-auto">
                                    <span>8.92K</span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 75%; background: #0075b0" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-1 mb-3 d-flex">
                            <div class="flex-shrink-0 me-2">
                                <img src="{{ asset('dashboard/images/brands/edge.png') }}" width="24"
                                    alt="">
                            </div>
                            <div class="flex-grow-1 d-flex">
                                <div>
                                    <span>Edge</span>
                                    <small class="text-muted fs-10 d-block">Lorem ipsum dolor sit.</small>
                                </div>
                                <div class="ms-auto">
                                    <span>8.92K</span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 28%; background: #109ee5" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-1 mb-3 d-flex">
                            <div class="flex-shrink-0 me-2">
                                <img src="{{ asset('dashboard/images/brands/brave.png') }}" width="24"
                                    alt="">
                            </div>
                            <div class="flex-grow-1 d-flex">
                                <div>
                                    <span>Brave</span>
                                    <small class="text-muted fs-10 d-block">Lorem ipsum dolor sit.</small>
                                </div>
                                <div class="ms-auto">
                                    <span>8.92K</span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 7%; background: #eb3116" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-1 mb-3 d-flex">
                            <div class="flex-shrink-0 me-2">
                                <img src="{{ asset('dashboard/images/brands/opera.png') }}" width="24"
                                    alt="">
                            </div>
                            <div class="flex-grow-1 d-flex">
                                <div>
                                    <span>Opera</span>
                                    <small class="text-muted fs-10 d-block">Lorem ipsum dolor sit.</small>
                                </div>
                                <div class="ms-auto">
                                    <span>8.92K</span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 45%; background: #e5141c" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-1 mb-3 d-flex">
                            <div class="flex-shrink-0 me-2">
                                <img src="{{ asset('dashboard/images/brands/uc.png') }}" width="24"
                                    alt="">
                            </div>
                            <div class="flex-grow-1 d-flex">
                                <div>
                                    <span>UC Browser</span>
                                    <small class="text-muted fs-10 d-block">Lorem ipsum dolor sit.</small>
                                </div>
                                <div class="ms-auto">
                                    <span>8.92K</span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 52%; background: #db871b" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/vendors/apexchart/apexcharts.css') }}">
    @endpush

    @push('js')
        <script src="{{ asset('dashboard/vendors/apexchart/apexcharts.min.js') }}"></script>
        <script>
            var visitsChartOptions = {
                series: [{
                        name: "series1",
                        data: [105, 70, 28, 51, 42, 109, 100],
                    },
                    {
                        name: "series2",
                        data: [11, 32, 45, 32, 34, 52, 41],
                    },
                ],
                chart: {
                    height: 125,
                    type: "area",
                    sparkline: {
                        enabled: true,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: "smooth",
                },
                xaxis: {
                    type: "datetime",
                    categories: [
                        "2018-09-19T00:00:00.000Z",
                        "2018-09-19T01:30:00.000Z",
                        "2018-09-19T02:30:00.000Z",
                        "2018-09-19T03:30:00.000Z",
                        "2018-09-19T04:30:00.000Z",
                        "2018-09-19T05:30:00.000Z",
                        "2018-09-19T06:30:00.000Z",
                    ],
                },
                tooltip: {
                    x: {
                        format: "dd/MM/yy HH:mm",
                    },
                },
            };
            var visitsChart = new ApexCharts(
                document.querySelector("#views-chart"),
                visitsChartOptions
            );
            visitsChart.render();
        </script>
    @endpush
</x-app-layout>
