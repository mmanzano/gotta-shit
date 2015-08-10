<div>

    <label class="input-label" for="full_name">
        {{ ucfirst(trans('gottashit.user.full_name')) }}
    </label>

    @if(old('full_name') != "")
        <input class="input" type="text" name="full_name" value="{{ old('full_name') }}" id="full_name">
    @elseif(isset($user))
        <input class="input" type="text" name="full_name" value="{{ $user->full_name }}" id="full_name">
    @else
        <input class="input" type="text" name="full_name" value="" id="full_name">
     @endif

</div>
<div>

    <label class="input-label" for="username">
        {{ ucfirst(trans('gottashit.user.username')) }}
    </label>

    @if(old('username') != "")
        <input class="input" type="text" name="username" value="{{ old('username') }}" id="username">
    @elseif(isset($user))
        <input class="input" type="text" name="username" value="{{ $user->username }}" id="username">
    @else
        <input class="input" type="text" name="username" value="" id="username">
    @endif

</div>

<div>

    <label class="input-label" for="email">
        {{ ucfirst(trans('gottashit.user.email')) }}
    </label>

    @if(old('email') != "")
        <input class="input" type="email" name="email" value="{{ old('email') }}" id="email">
    @elseif(isset($user))
        <input class="input" type="email" name="email" value="{{ $user->email }}" id="email">
    @else
        <input class="input" type="email" name="email" value="" id="email">
    @endif

</div>

<div>

    <label class="input-label" for="password">
        {{ ucfirst(trans('gottashit.user.password')) }}
    </label>

    <input class="input" type="password" name="password" id="password">

</div>

<div>

    <label class="input-label" for="password_confirmation">
        {{ ucfirst(trans('gottashit.user.confirm_password')) }}
    </label>

    <input class="input" type="password" name="password_confirmation" id="password_confirmation">

</div>
