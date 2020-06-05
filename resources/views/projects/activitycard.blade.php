<ul>
@foreach($project->activity as $activity)
    <li class="list-reset {{$loop->last ? '' : 'mb-1'}}">
        <div class="text-sm -mx-10">{{$activity->user->name}} 
            {{$activity->subject != null ? str_replace("_"," a ",$activity->description)." ".$activity->subject->body : str_replace("_"," a ",$activity->description)}}
        <div>
        <div class="text-xs text-grey">{{$activity->created_at->diffForHumans()}}</div>
        </li>
@endforeach
</ul>