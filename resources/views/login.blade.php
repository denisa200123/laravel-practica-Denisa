<x-layout>
    <x-slot name="title"> Login </x-slot>

    <x-header />

    <x-validation-messages />

    <h2 style="margin-left: 20px;">Login info</h2>
    <form action="{{ route('login.submit') }}" method="post">
        @csrf
        <div style="display: flex; flex-direction: column; width: fit-content; height: fit-content; margin-left: 20px;">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required value="{{ old('username') }}">
    
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required value="{{ old('password') }}">
            
            <br>
    
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>

</x-layout>