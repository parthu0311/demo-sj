<div>
    <h3>Hi {{ $users->first_name ." ". $users->last_name }},</h3>
    <p>Welcome to Suril Jain. We have registered you with us.</p>
    <p>Your Account Details are :</p>
    <table>
        <tr>
            <td>Name:</td>
            <td>{{ $users->first_name. " ".$users->last_name }}</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>{{ $users->email }}</td>
        </tr>
        <tr>
            <td>password:</td>
            <td>{{ $users->password }}</td>
        </tr>
        <tr>
            <td>Phone Number:</td>
            <td>{{ $users->contact_number }}</td>
        </tr>
    </table>
    <p> Thank you! Suril Jain Team </p>
</div>
