<?php $email = base64_encode($user->email); ?>
<div>
    <h3>Hi {{ $user->username }},</h3> 
    <p>Welcome to Suril Jain Admin Panel. For Your Activatation Account click on below link.</p>
    <!--<a href="{{ asset('api/activateAccount/'.$user->id) }}">{{ $_SERVER['SERVER_NAME'] }}/api/verify/{{ $email }}</a> -->
    <a href="{{ asset('api/activateAccount/'.$user->id) }}">{{ asset('api/verify/'{{ $email }})</a>
    <p> Thank you! Suril Jain Team </p>
</div>    
   