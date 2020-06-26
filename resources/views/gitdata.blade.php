<table class="table table-bordered ">
    <thead>
        <tr>
            <th class="text-center"> Image</th>
            <th class="text-center"> Name</th>
            <th class="text-center"> Total Repositories</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            
            <tr>
                <td class="text-center">
                	<img src="{{ $user['avatar_url']}}" class='mr-10 img-circle custom-image'>
                </td>
                <td class="text-center pt-20">
                    {{ ucfirst($user['name']) }}
                </td>
                <td class="text-center pt-20">
                   {{ $user['total_repos'] }}
                </td>
            </tr>
        
        @endforeach
    </tbody>
</table>