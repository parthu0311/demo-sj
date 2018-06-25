<div>
    <h3>Hi {{ $users->first_name }},</h3> 
    <p>Welcome to Suril Jain Admin panel. You can change the password click on below link.</p>
    <a href="{{ asset('admin/resetpasswordpage/'.$userID) }}">Reset Password Link.</a>
    <p> Thank you! Admin panel Team </p>
</div>    
   