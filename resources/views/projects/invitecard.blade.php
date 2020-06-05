<div class="card">
                <div class="card flex flex-col">
                    <h3 class="font-normal text-xl  -ml-5 border-l-4 border-blue-light pl-4 mb-3">
                    Invite A User
                    </h3>
                    <form method="POST"action="{{$project->path() . '/invite'}}">
                        @csrf
                        <div class="mb-3">
                            <input 
                            type="email" 
                            name="email" 
                            class="border border-grey rounded py-2 px-3 w-full"
                            placeholder="Email Address"
                            >
                        </div>
                        <div class="text-right">
                        <button class="button" type="submit" class="text-sm">Invite</button>
                        </div>
                        
                    </form>
                    
                </div>
            </div>