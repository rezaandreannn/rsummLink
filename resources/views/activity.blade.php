<x-app-layout title="{{ $title ?? '' }}">
    <x-section.section>
        <x-section.header :title="$title" />

        <div class="section-body">
            <h2 class="section-title">{{ date('d, M Y')}}</h2>
            <div class="row">
                <div class="col-12">
                    <div class="activities">
                        @foreach($activities as $activity)
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                @switch($activity->activity_type)
                                @case('created')
                                <i class="fas fa-folder-plus"></i>
                                @break
                                @case('updated')
                                <i class="fas fa-wrench"></i>
                                @break
                                @case('deleted')
                                <i class="fas fa-trash"></i>
                                @break

                                $@default

                                @endswitch
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job text-primary">{{$activity->created_at->timezone('Asia/Jakarta')->diffForHumans()}}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">{{$activity->activity_type ?? ''}}</a>
                                    <div class="float-right dropdown">
                                        <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu">
                                            <div class="dropdown-title">Options</div>
                                            <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                            <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item has-icon text-danger" data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?" data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i> Archive</a>
                                        </div>
                                    </div>
                                </div>
                                <p>{{ $activity->description }} "<a href="#">Responsive design</a>".</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-section.section>
</x-app-layout>
