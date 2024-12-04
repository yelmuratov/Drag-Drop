<div class="container-fluid">
    <h1 class="my-4 text-center">Attendance Management System</h1>
    <div class="table-responsive">
        <!-- Display the selected date -->
        <table class="table table-bordered w-100">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">FIO</th>
                @foreach($days as $day)
                    <th scope="col">{{ \Carbon\Carbon::parse($day)->format('d') }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              <!-- Date input field -->
              <input wire:model="date" wire:change="updateDate($event.target.value)" type="date" name="date" id="date" class="form-control mb-3 btn">
              <h1>Selected Date: {{ \Carbon\Carbon::parse($date)->toFormattedDateString() }}</h1>
              @foreach($users as $user)
                <tr>
                  <th scope="row">{{ $user->id }}</th>
                  <td>{{ $user->name }}</td>
                    @foreach($days as $day)
                        <td wire:click = "Attendance('{{ $day }}', '{{ $user->id }}', $event.target.value)">
                            @if($UserId==$user->id && $AttendanceDate==$day)
                                <input wire:model="attendanceStatus" type="text" value="text" class="form-control" wire:keydown.enter="SaveAttendance('{{ $user->id }}', '{{ $day }}', $event.target.value)">
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
