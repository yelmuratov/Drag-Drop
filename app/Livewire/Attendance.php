<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;

class Attendance extends Component
{   

    public $users;
    public $date;
    public $monthEnd;
    public $days = [];
    public $attendanceStatus;
    public $UserId;
    public $AttendanceDate;

    public function mount()
    {   
        $this->users = User::all();
        $this->date = Carbon::now()->format('Y-m-d');
        $this->monthEnd = Carbon::parse($this->date)->endOfMonth()->format('Y-m-d');
        $this->days = collect(range(1, Carbon::parse($this->date)->daysInMonth))->map(function($day){
            return Carbon::parse($this->date)->startOfMonth()->addDays($day - 1)->format('Y-m-d');
        });
    }

    public function render()
    {   
        return view('livewire.attendance')->layout('components.layouts.app');
    }

    public function updateDate($date){
        $this->date = Carbon::parse($date)->format('Y-m-d');
        $this->days = collect(range(1, Carbon::parse($this->date)->daysInMonth))->map(function($day){
            return Carbon::parse($this->date)->startOfMonth()->addDays($day - 1)->format('Y-m-d');
        });
    }

    public function Attendance($date, $userId){
        $this->AttendanceDate = $date;
        $this->UserId = $userId;
    }

    public function SaveAttendance($userId, $date, $status)
    {
        // Validate user existence
        $user = User::find($userId);

        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        // Save or update attendance record
        $attendance = $user->attendances()->updateOrCreate(
            [
                'user_id' => $userId,
            ],
            [
                'date' => $date,
            ],
            [
                'status' => $status, // Data to update or insert
            ]
        );

        // Flash success message
        session()->flash('success', 'Attendance successfully saved.');

        // Reset the form
        $this->reset('UserId', 'AttendanceDate', 'attendanceStatus');
    }

    
}
