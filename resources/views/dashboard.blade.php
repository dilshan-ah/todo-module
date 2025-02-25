@extends('master')

@section('main-content')
    <div class="container my-5">
        <div class="row">
            <div class="col-sm-3">
              <div class="card bg-primary text-light">
                <div class="card-body">
                  <h5 class="card-title">{{$upcomingTasks->count()}}</h5>
                  <p class="card-text">Upcoming Task</p>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card bg-info text-light">
                <div class="card-body">
                  <h5 class="card-title">{{$inprogressTasks->count()}}</h5>
                  <p class="card-text">InProgress</p>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
                <div class="card bg-danger text-light">
                  <div class="card-body">
                    <h5 class="card-title">{{$pendingTasks->count()}}</h5>
                    <p class="card-text">Pending</p>
                  </div>
                </div>
              </div>

              <div class="col-sm-3">
                <div class="card bg-success text-light">
                  <div class="card-body">
                    <h5 class="card-title">{{$completedTasks->count()}}</h5>
                    <p class="card-text">Completed</p>
                  </div>
                </div>
              </div>
          </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-box shadow">
                        <h4 class="text-dark header-title mb-4">Upcoming</h4>
                        <ul class="sortable-list taskList list-unstyled ui-sortable" id="upcoming">
                            @foreach ($upcomingTasks as $upcomingTask)
                            <li class="task-warning ui-sortable-handle" id="task1">
                                <h6>{{$upcomingTask->title}}</h6>
                                <p class="text-muted m-b-30 font-13">{{$upcomingTask->description}}</p>
                                
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <p class="mb-0">
                                        Assigned to: <br>
                                        <a href="" class="text-muted"> 
                                            <span class="font-bold font-secondary">{{$upcomingTask->assignedTo->name}}</span>
                                        </a>
                                    </p>
                                    <p class="mb-0">
                                        Assigned by: <br>
                                        <a href="" class="text-muted"> 
                                            <span class="font-bold font-secondary">{{$upcomingTask->createdBy->name}}</span>
                                        </a>
                                    </p>
                                </div>

                                <p class="d-flex gap-2 mb-0 mt-2">
                                    <a type="button" class="btn btn-info btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#edit{{$upcomingTask->id}}">Edit</a>
                                    <a type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{$upcomingTask->id}}">Delete</a>
                                </p>
                            </li>

                            {{-- delete modal --}}
                            <div class="modal fade" id="delete{{$upcomingTask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure?
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <form action="{{route('task.delete',$upcomingTask->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                      </form>
                                      
                                    </div>
                                  </div>
                                </div>
                            </div>

                            {{-- edit modal --}}
                            <div class="modal fade" id="edit{{$upcomingTask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                            
                                      <form action="{{route('task.update',$upcomingTask->id)}}" method="post">
                                        @csrf
                                        @method('put')

                                        <label>Task title</label>
                                        <input type="text" value="{{$upcomingTask->title}}" name="title" placeholder="Task title" class="form-control mb-2">
                                        
                                        <label>Task description</label>
                                        <textarea name="description" placeholder="Task description" class="form-control mb-2">
                                            {{$upcomingTask->description}}
                                        </textarea>
                            
                                        <label>Assign task to</label>
                                        <select class="form-select mb-2" name="given" aria-label="Default select example">
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}" @if($upcomingTask->assignedTo->id == $user->id) selected @endif>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                            
                                        <label>Task status</label>
                                        <select class="form-select" name="status" aria-label="Default select example">
                                          <option value="upcoming" @if($upcomingTask->status == 'upcoming') selected @endif>Upcoming</option>
                                            <option value="inprogress" @if($upcomingTask->status == 'inprogress') selected @endif>InProgress</option>
                                            <option value="pending" @if($upcomingTask->status == 'pending') selected @endif>Pending</option>
                                            <option value="completed" @if($upcomingTask->status == 'completed') selected @endif>Completed</option>
                                        </select>
                            
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                          </div>
                                      </form>
                            
                                    </div>
                                    
                                  </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card-box shadow">
                        <h4 class="text-dark header-title mb-4">In Progress</h4>
                        <ul class="sortable-list taskList list-unstyled ui-sortable" id="inprogress">
                            @foreach ($inprogressTasks as $inprogressTask)
                            <li class="task-warning ui-sortable-handle" id="task1">
                                <h6>{{$inprogressTask->title}}</h6>
                                <p class="text-muted m-b-30 font-13">{{$inprogressTask->description}}</p>
                                
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <p class="mb-0">
                                        Assigned to: <br>
                                        <a href="" class="text-muted"> 
                                            <span class="font-bold font-secondary">{{$inprogressTask->assignedTo->name}}</span>
                                        </a>
                                    </p>
                                    <p class="mb-0">
                                        Assigned by: <br>
                                        <a href="" class="text-muted"> 
                                            <span class="font-bold font-secondary">{{$inprogressTask->createdBy->name}}</span>
                                        </a>
                                    </p>
                                </div>

                                <p class="d-flex gap-2 mb-0 mt-2">
                                  <a type="button" class="btn btn-info btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#edit{{$inprogressTask->id}}">Edit</a>
                                  <a type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{$inprogressTask->id}}">Delete</a>
                                </p>
                            </li>

                            {{-- delete modal --}}
                            <div class="modal fade" id="delete{{$inprogressTask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      Are you sure?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="{{route('task.delete',$inprogressTask->id)}}" method="post">
                                      @csrf
                                      @method('delete')
                                      <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    
                                  </div>
                                </div>
                              </div>
                          </div>

                          {{-- edit modal --}}
                          <div class="modal fade" id="edit{{$inprogressTask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                          
                                    <form action="{{route('task.update',$inprogressTask->id)}}" method="post">
                                      @csrf
                                      @method('put')

                                      <label>Task title</label>
                                      <input type="text" value="{{$inprogressTask->title}}" name="title" placeholder="Task title" class="form-control mb-2">
                                      
                                      <label>Task description</label>
                                      <textarea name="description" placeholder="Task description" class="form-control mb-2">
                                          {{$inprogressTask->description}}
                                      </textarea>
                          
                                      <label>Assign task to</label>
                                      <select class="form-select mb-2" name="given" aria-label="Default select example">
                                          @foreach ($users as $user)
                                          <option value="{{$user->id}}" @if($inprogressTask->assignedTo->id == $user->id) selected @endif>{{$user->name}}</option>
                                          @endforeach
                                      </select>
                          
                                      <label>Task status</label>
                                      <select class="form-select" name="status" aria-label="Default select example">
                                        <option value="upcoming" @if($inprogressTask->status == 'upcoming') selected @endif>Upcoming</option>
                                          <option value="inprogress" @if($inprogressTask->status == 'inprogress') selected @endif>InProgress</option>
                                          <option value="pending" @if($inprogressTask->status == 'pending') selected @endif>Pending</option>
                                          <option value="completed" @if($inprogressTask->status == 'completed') selected @endif>Completed</option>
                                      </select>
                          
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                          
                                  </div>
                                  
                                </div>
                              </div>
                          </div>
                            @endforeach
                        </ul></div>
                </div>
                <div class="col-lg-4">
                    <div class="card-box shadow">
                        <h4 class="text-dark header-title mb-4">Completed</h4>
                        <ul class="sortable-list taskList list-unstyled ui-sortable" id="inprogress">
                            @foreach ($completedTasks as $completedTask)
                            <li class="task-warning ui-sortable-handle" id="task1">
                                <h6>{{$completedTask->title}}</h6>
                                <p class="text-muted m-b-30 font-13">{{$completedTask->description}}</p>
                                
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <p class="mb-0">
                                        Assigned to: <br>
                                        <a href="" class="text-muted"> 
                                            <span class="font-bold font-secondary">{{$completedTask->assignedTo->name}}</span>
                                        </a>
                                    </p>
                                    <p class="mb-0">
                                        Assigned by: <br>
                                        <a href="" class="text-muted"> 
                                            <span class="font-bold font-secondary">{{$completedTask->createdBy->name}}</span>
                                        </a>
                                    </p>
                                </div>

                                <p class="d-flex gap-2 mb-0 mt-2">
                                  <a type="button" class="btn btn-info btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#edit{{$completedTask->id}}">Edit</a>
                                  <a type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{$completedTask->id}}">Delete</a>
                                </p>
                            </li>

                            {{-- delete modal --}}
                            <div class="modal fade" id="delete{{$completedTask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      Are you sure?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="{{route('task.delete',$completedTask->id)}}" method="post">
                                      @csrf
                                      @method('delete')
                                      <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    
                                  </div>
                                </div>
                              </div>
                          </div>

                          {{-- edit modal --}}
                          <div class="modal fade" id="edit{{$completedTask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                          
                                    <form action="{{route('task.update',$completedTask->id)}}" method="post">
                                      @csrf
                                      @method('put')

                                      <label>Task title</label>
                                      <input type="text" value="{{$completedTask->title}}" name="title" placeholder="Task title" class="form-control mb-2">
                                      
                                      <label>Task description</label>
                                      <textarea name="description" placeholder="Task description" class="form-control mb-2">
                                          {{$completedTask->description}}
                                      </textarea>
                          
                                      <label>Assign task to</label>
                                      <select class="form-select mb-2" name="given" aria-label="Default select example">
                                          @foreach ($users as $user)
                                          <option value="{{$user->id}}" @if($completedTask->assignedTo->id == $user->id) selected @endif>{{$user->name}}</option>
                                          @endforeach
                                      </select>
                          
                                      <label>Task status</label>
                                      <select class="form-select" name="status" aria-label="Default select example">
                                        <option value="upcoming" @if($completedTask->status == 'upcoming') selected @endif>Upcoming</option>
                                          <option value="inprogress" @if($completedTask->status == 'inprogress') selected @endif>InProgress</option>
                                          <option value="pending" @if($completedTask->status == 'pending') selected @endif>Pending</option>
                                          <option value="completed" @if($completedTask->status == 'completed') selected @endif>Completed</option>
                                      </select>
                          
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                          
                                  </div>
                                  
                                </div>
                              </div>
                          </div>
                            @endforeach
                        </ul></div>
                </div>
                <div class="col-lg-4">
                    <div class="card-box shadow">
                        <h4 class="text-dark header-title mb-4">Pending</h4>
                        <ul class="sortable-list taskList list-unstyled ui-sortable" id="inprogress">
                            @foreach ($pendingTasks as $pendingTask)
                            <li class="task-warning ui-sortable-handle" id="task1">
                                <h6>{{$pendingTask->title}}</h6>
                                <p class="text-muted m-b-30 font-13">{{$pendingTask->description}}</p>
                                
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <p class="mb-0">
                                        Assigned to: <br>
                                        <a href="" class="text-muted"> 
                                            <span class="font-bold font-secondary">{{$pendingTask->assignedTo->name}}</span>
                                        </a>
                                    </p>
                                    <p class="mb-0">
                                        Assigned by: <br>
                                        <a href="" class="text-muted"> 
                                            <span class="font-bold font-secondary">{{$pendingTask->createdBy->name}}</span>
                                        </a>
                                    </p>
                                </div>

                                <p class="d-flex gap-2 mb-0 mt-2">
                                  <a type="button" class="btn btn-info btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#edit{{$pendingTask->id}}">Edit</a>
                                  <a type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{$pendingTask->id}}">Delete</a>
                                </p>
                            </li>

                            {{-- delete modal --}}
                            <div class="modal fade" id="delete{{$pendingTask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      Are you sure?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="{{route('task.delete',$pendingTask->id)}}" method="post">
                                      @csrf
                                      @method('delete')
                                      <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    
                                  </div>
                                </div>
                              </div>
                          </div>

                          {{-- edit modal --}}
                          <div class="modal fade" id="edit{{$pendingTask->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                          
                                    <form action="{{route('task.update',$pendingTask->id)}}" method="post">
                                      @csrf
                                      @method('put')

                                      <label>Task title</label>
                                      <input type="text" value="{{$pendingTask->title}}" name="title" placeholder="Task title" class="form-control mb-2">
                                      
                                      <label>Task description</label>
                                      <textarea name="description" placeholder="Task description" class="form-control mb-2">
                                          {{$pendingTask->description}}
                                      </textarea>
                          
                                      <label>Assign task to</label>
                                      <select class="form-select mb-2" name="given" aria-label="Default select example">
                                          @foreach ($users as $user)
                                          <option value="{{$user->id}}" @if($pendingTask->assignedTo->id == $user->id) selected @endif>{{$user->name}}</option>
                                          @endforeach
                                      </select>
                          
                                      <label>Task status</label>
                                      <select class="form-select" name="status" aria-label="Default select example">
                                        <option value="upcoming" @if($pendingTask->status == 'upcoming') selected @endif>Upcoming</option>
                                          <option value="inprogress" @if($pendingTask->status == 'inprogress') selected @endif>InProgress</option>
                                          <option value="pending" @if($pendingTask->status == 'pending') selected @endif>Pending</option>
                                          <option value="completed" @if($pendingTask->status == 'completed') selected @endif>Completed</option>
                                      </select>
                          
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                          
                                  </div>
                                  
                                </div>
                              </div>
                          </div>
                            @endforeach
                        </ul></div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>


    <button class="btn btn-info position-fixed fw-bold shadow" style="right: 20px; bottom: 20px" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Task</button>

    {{-- add modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="{{route('task.store')}}" method="post">
            @csrf

            <label>Task title</label>
            <input type="text" name="title" placeholder="Task title" class="form-control mb-2">
            
            <label>Task description</label>
            <textarea name="description" placeholder="Task description" class="form-control mb-2"></textarea>

            <label>Assign task to</label>
            <select class="form-select mb-2" name="given" aria-label="Default select example">
                @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>

            <label>Task status</label>
            <select class="form-select" name="status" aria-label="Default select example">
              <option value="upcoming">Upcoming</option>
                <option value="inprogress">InProgress</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
          </form>

        </div>
        
      </div>
    </div>
</div>


@endsection