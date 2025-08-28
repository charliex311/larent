<div>
    <div>
        @include('backend.users-tabs')

        @canany(['users-manage-permissions'])

        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <form wire:submit.prevent="savePermissions">
                    <div class="card mb-2 shadow-sm">
                        <div class="card-header">
                            <div class="d-lg-flex justify-content-between">
                                <div class="col-auto"><b> Manage Permissions: </b></div>
                                <div class="col-auto"><h3>{{ $row ? '('.fullName($row->id).')' : ''}}</h3></div>
                                <div class="col-auto"><a href="/admin/users?type={{$role}}" class="btn btn-primary btn-sm">Back</a></div>
                            </div>
                        </div>
                        <div class="card-body">
                            @php $groupedItems = []; @endphp
                            @foreach($permissions as $item)
                                @php 
                                    $words = explode('-', $item->name);
                                    $groupName = $words[0];
                                    $secondWord = isset($words[1]) ? $words[1] : $item->name;
                                    $thirdWord = isset($words[2]) ? $words[2] : '';
                                    $fotrhWord = isset($words[3]) ? $words[3] : '';
                                    $groupedItems[$groupName][] = [$item->id, $secondWord, $thirdWord, $fotrhWord];
                                @endphp
                            @endforeach
                            <div class="row">
                                @foreach($groupedItems as $groupName => $groupItems)
                                @php $groupPermissionCheckedCounter=0; @endphp
                                <div class="col-sm-12 col-md-3 col-lg-3 g-2">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                <h6 class="mb-0 text-capitalize"><b>{{$groupName}}</b></h6>
                                                </div>
                                                <div class="col-auto text-center pe-x1">
                                                    <!--div class="form-check mb-0 d-flex align-items-center">
                                                        <input 
                                                        type="checkbox" 
                                                        class="form-check-input rounded-circle p-1 form-check-input-primary check-all" 
                                                        id="{{$groupName}}"
                                                        value="{{$groupName}}"
                                                        wire:click="addPermissionAsGroup({{json_encode($groupItems)}})"
                                                        @foreach($groupItems as $name)
                                                            @if(!empty($role_name)) @if(
                                                                count(Spatie\Permission\Models\Role::findByName($role_name)->permissions ) != 0 )
                                                            @foreach( Spatie\Permission\Models\Role::findByName($role_name)->permissions as $p)
                                                            @if($p->id == $name[0])
                                                                @php $groupPermissionCheckedCounter+=1; @endphp
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                            @endif
                                                        @endforeach

                                                        @if(count($groupItems) == $groupPermissionCheckedCounter)
                                                        checked=""
                                                        @endif 

                                                        />
                                                        <label class="form-check-label mb-0 p-1" for="{{$groupName}}"> Check All </label>
                                                    </div-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                        @foreach($groupItems as $name)
                                        <div class="form-check mb-0 d-flex align-items-center">

                                            <input 
                                            type="checkbox" 
                                            class="form-check-input rounded-circle p-2 form-check-input-primary group-{{$groupName}}"
                                            wire:click="addPermission({{ $name[0] }})" 
                                            id="check{{$name[0]}}" 
                                            value="{{ $name[1] }}" 

                                                @if(!empty($row))
                                                    @if(count($row->permissions ) != 0 )
                                                        @foreach($row->permissions as $p)
                                                            @if($p->id == $name[0])
                                                                checked=""
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            />
                                            
                                            <label class="form-check-label mb-0 p-1" for="check{{$name[0]}}"> {{$name[1]?$name[1]:''}}{{$name[2]?'-'.$name[2]:''}}{{$name[3]?'-'.$name[3]:''}} </label>
                                        </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @if(role_name($row->id) != role_name(Auth::id()))

                            <div class="form-group my-5">
                                <button type="submit" class="btn btn-primary btn-flat">Save Changes</button> 
                                @if(Session::has('success')) <span class=" btn text-success btn-green"><i class="fe fe-check mr-2"></i> {{ Session::get('success') }}</span> @endif
                            </div>

                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @endcanany

        <script>
            document.addEventListener('livewire:navigated', function () {
                // JavaScript function to handle group-wise "Check All" checkboxes
                const checkAllCheckboxes = (groupName, checked) => {
                    const groupCheckboxes = document.querySelectorAll(`.group-${groupName}`);
                    groupCheckboxes.forEach((checkbox) => {
                        checkbox.checked = checked;
                    });
                };
        
                // Add event listeners to the "Check All" checkboxes
                const checkAllCheckboxesInputs = document.querySelectorAll('.check-all');
                checkAllCheckboxesInputs.forEach((input) => {
                    input.addEventListener('change', (e) => {
                        const groupName = e.target.value;
                        const checked = e.target.checked;
                        checkAllCheckboxes(groupName, checked);
                    });
                });
            });

            /*for just DOM*/
            // JavaScript function to handle group-wise "Check All" checkboxes
            const checkAllCheckboxes = (groupName, checked) => {
                const groupCheckboxes = document.querySelectorAll(`.group-${groupName}`);
                groupCheckboxes.forEach((checkbox) => {
                    checkbox.checked = checked;
                });
            };

            // Add event listeners to the "Check All" checkboxes
            const checkAllCheckboxesInputs = document.querySelectorAll('.check-all');
            checkAllCheckboxesInputs.forEach((input) => {
                input.addEventListener('change', (e) => {
                    const groupName = e.target.value;
                    const checked = e.target.checked;
                    checkAllCheckboxes(groupName, checked);
                });
            });
        </script>

    </div>
</div>