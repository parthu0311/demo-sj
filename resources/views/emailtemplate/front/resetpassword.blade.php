<div>
    <h3>Hi {{ $users->first_name ." ". $users->last_name }},</h3>
    <p>Welcome to Suril Jain. You can change the password click on below link.</p>
    <a href="{{ url('resetPassword/'.$users->token) }}">Reset Password Link.</a>
    <p> Thank you! Suril Jain Team </p>
</div>
