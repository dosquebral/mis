<?php

use App\Events\RequestEvent;
use App\Models\Category;
use App\Models\Request;
use App\Models\TaskList;
use App\Models\User;
use App\Notifications\RequestStatus;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{state, mount, rules};

state(['checked', 'page',]);


state(['category', 'task', 'request']);

rules([
    'task' => 'required'
]);

mount(function () {


    $this->request = Request::find(session('requestId'));


    if (request()->route()->getName() == 'request') {
        //to get the percentage
        $this->checked = round($this->request->progress / 100 * count($this->request->category->taskList));
    }
});

$addTaskList = function () {
    $this->validate();
    $taskList = TaskList::create([
        'category_id' => $this->category,
        'task' => $this->task,
    ]);
    $this->reset();

    $this->category = $taskList->category_id;
};

$deleteTaskList = function ($id) {
    $taskList = TaskList::find($id);
    $taskList->delete();
    $this->dispatch('success', 'sucessfully deleted');
};

$viewTaskList = function () {
    return TaskList::where('category_id', $this->category)->get();
};

$check = function ($list) {

    $this->checked = $list;
    $req = Request::find($this->request->id);
    $progress = round($this->checked / count($req->category->taskList) * 100);
    $req->progress = $progress;

    if ($req->progress == 100) {
        $req->status = 'resolved';
        $faculty = User::find($req->faculty_id);
        $faculty->notify(new RequestStatus($req));
    }

    $req->save();
    $this->dispatch('view-detailed-request');
    RequestEvent::dispatch($req->faculty_id);
    $this->page = 'request';
}
?>

<div class="relative rounded-md">
   

    @include('components.task-list.view-task-list')


</div>